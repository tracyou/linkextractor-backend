<?php

declare(strict_types=1);

namespace App\Helpers\Import;

use SimpleXMLElement;
use App\Structs\LawStruct;
use App\Structs\ArticleStruct;

final class LawXmlImport
{
    public function import(string $xmlString): void
    {
        ini_set('memory_limit', '-1');
        $data = simplexml_load_string($xmlString);
        if (! $data) {
            return;
        }
        $law = $this->parseDataToStruct($data);
        $law->save();
    }

    private function parseDataToStruct(SimpleXMLElement $data): LawStruct
    {
        $law = $this->getLaw($data);
        $articles = $this->getArticles($data);

        foreach ($articles as $article) {
            $hydratedArticle = $this->hydrateLaw($article);
            $law->add($hydratedArticle);
        }

        return $law;
    }

    private function getLaw(SimpleXMLElement $data): LawStruct
    {
        return new LawStruct($this->trim((string) $data->wetgeving->citeertitel));
    }

    private function trim(string $string): string
    {
        return trim($string);
    }

    private function getArticles(SimpleXMLElement $data, array &$articles = []): array
    {
        foreach ($data->children() as $child) {
            if ($child->getName() === 'artikel') {
                $articles[] = $child;
            } else {
                $articles = $this->getArticles($child, $articles);
            }
        }
        return $articles;
    }

    private function hydrateLaw(SimpleXMLElement $article): ArticleStruct
    {
        $articleStruct = new ArticleStruct();
        $kop = $article->kop;
        $articleStruct->label = (string) $kop->label;
        $articleStruct->nr = (string) $kop->nr;
        $articleStruct->titel = (string) $kop->titel;
        $articleStruct->text = $this->getText($article);

        return $articleStruct;
    }


    private function getText(SimpleXMLElement $article): string
    {
        $al = $this->trim(preg_replace('/<[^>]*>/', '', $article->al->asXML() ?: ''));
        $list = $this->trim(preg_replace('/<[^>]*>/', '', $article->lijst->asXML() ?: ''));

        $lid = '';
        foreach ($article->lid as $lidItem) {
            $lid .= $this->trim(preg_replace('/<[^>]*>/', '', $lidItem->asXML() ?: ''));
        }

        return $al . $list . $lid;
    }
}
