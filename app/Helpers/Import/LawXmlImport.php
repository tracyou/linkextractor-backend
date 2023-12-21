<?php

declare(strict_types=1);

namespace App\Helpers\Import;

use App\Structs\ArticleStruct;
use App\Structs\LawStruct;
use SimpleXMLElement;

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
        $wetBesluit = 'wet-besluit';
        $wetText = $data->wetgeving->$wetBesluit->wettekst;
        foreach ($wetText->hoofdstuk as $chapter) {
            foreach ($chapter->paragraaf as $paragraph) {
                foreach ($paragraph->artikel as $article) {
                    $hydratedArticle = $this->hydrateLaw($article);
                    $law->add($hydratedArticle);
                }
            }
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
