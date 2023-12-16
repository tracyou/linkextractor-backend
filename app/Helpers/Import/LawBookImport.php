<?php

declare(strict_types=1);

namespace App\Helpers\Import;


use App\Structs\LawStruct;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class LawBookImport
{
    public function import(string $xmlString): bool
    {
        $data = $this->toArray($xmlString);
        $lawBook = $this->parseDataToStruct($data);

        foreach ($lawBook as $law) {
            $model = $law->toModel();
            $model?->save();
        }

        return true;
    }

    /** @return array<mixed> */
    private function toArray(string $xmlString): array
    {
        $xmlObject = simplexml_load_string($xmlString);
        $json = json_encode($xmlObject);
        if ($json) {
            /** @var array<mixed, mixed> */
            return json_decode($json, true);
        }
        return [];
    }

    /**
     * @param array<mixed> $data
     *
     * @return Collection<LawStruct>
     */
    private function parseDataToStruct(array $data): Collection
    {
        $lawBookStructCollection = new Collection();
        foreach (Arr::get($data, 'wetgeving.wet-besluit.wettekst.hoofdstuk', []) as $chapter) {
            foreach (Arr::get($chapter, 'paragraaf', []) as $paragraph) {
                $law = $this->hydrateLaw($paragraph['artikel']);
                $lawBookStructCollection->add($law);
            }
        }
        return $lawBookStructCollection;
    }

    /** @param array<mixed> $article */
    private function hydrateLaw(array $article): LawStruct
    {
        $lawStruct = new LawStruct();
        foreach ($article as $value) {
            if (is_array($value)) {
                $text = Arr::get($value, 'al');
                $list = Arr::get($value, 'lijst', []);

                if (is_array($text)) {
                    $text = trim(implode('', $text));
                }

                if (is_array($list)) {
                    $text .= trim($this->getListedText($list));
                } else {
                    $text .= trim($list);
                }

                $lawStruct->label = Arr::get($value, 'kop.label');
                $lawStruct->nr = Arr::get($value, 'kop.nr');
                $lawStruct->titel = Arr::get($value, 'kop.titel');
            } else {
                $text = $value;
            }
            $lawStruct->text = $text;
        }
        return $lawStruct;
    }

    /** @param array<string, mixed> $list */
    private function getListedText(array $list): string
    {
        $text = '';
        foreach ($list as $listItem) {
            foreach ($listItem as $item) {
                if (! is_array($item)) {
                    continue;
                }

                $litnr = null;
                if (array_key_exists('li.nr', $item)) {
                    $litnr = trim($item['li.nr']);
                }

                $al = Arr::get($item, 'al');

                if (! $litnr) {
                    dd($litnr);
                }

                if (is_array($al)) {
                    $al = implode('', Arr::flatten($al));
                }
                $text .= "$litnr $al\n";
            }
        }
        return $text;
    }
}
