<?php

declare(strict_types=1);

namespace App\Helpers\Import;

use DOMDocument;
use App\Models\Law;
use SimpleXMLElement;
use GraphQL\Error\Error;
use App\Structs\LawStruct;
use App\Structs\ArticleStruct;

final class LawXmlImport
{
    private int $sortOrder = 0;

    public function import(string $xmlFilePath): Law
    {
        ini_set('memory_limit', '-1');

        if (! $this->isValidXML($xmlFilePath)) {
            throw new Error("invalid xml data");
        }

        if (! $data = simplexml_load_file($xmlFilePath)) {
            throw new Error("invalid xml data");
        }

        $lawStruct = $this->parseDataToStruct($data);

        return $lawStruct->save();
    }

    /** @throws Error */
    protected function isValidXML(string $xmlFilePath): bool
    {
        $xsdFilePath = storage_path('app/XmlValidation/toestand_2016-1.xsd');

        if (! file_exists($xmlFilePath)) {
            throw new Error('XML file not found');
        }

        if (! file_exists($xsdFilePath)) {
            throw new Error('XSD file not found');
        }

        $tempDom = new DOMDocument();
        $tempDom->load($xmlFilePath);

        libxml_use_internal_errors(true);

        if (! $tempDom->schemaValidate($xsdFilePath)) {
            return false;
        }

        return true;
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

    /**
     * @param SimpleXMLElement[]  $articles
     *
     * @return SimpleXMLElement[]
     */
    private function getArticles(SimpleXMLElement $data, array &$articles = []): array
    {
        foreach ($data->children() as $child) {
            if ($child->getName() === 'artikel') {
                $articles[] = $child;
            } else {
                $this->getArticles($child, $articles);
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
        $articleStruct->sortOrder = $this->sortOrder++;

        return $articleStruct;
    }

    private function getText(SimpleXMLElement $article): string
    {
        $al = $this->trim((string) preg_replace('/<[^>]*>/', '', $article->al->asXML() ?: ''));
        $list = $this->trim((string) preg_replace('/<[^>]*>/', '', $article->lijst->asXML() ?: ''));

        $lid = '';
        foreach ($article->lid as $lidItem) {
            $lid .= $this->trim((string) preg_replace('/<[^>]*>/', '', $lidItem->asXML() ?: ''));
        }

        return $al . $list . $lid;
    }
}
