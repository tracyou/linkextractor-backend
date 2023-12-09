<?php

declare(strict_types=1);

namespace App\Helpers\Import;


use Illuminate\Support\Arr;
use App\Structs\LawBookStruct;
use Illuminate\Support\Collection;

final class LawBookImport
{
    public function import(string $xmlString): bool
    {
        $data = $this->toArray($xmlString);
        $lawBook = $this->parseDataToStruct($data);
//        dd($lawBook);
        return false;
    }

    /** @return array<mixed, mixed> */
    private function toArray(string $xmlString): array
    {
        $xmlObject = simplexml_load_string($xmlString);
        $json = json_encode($xmlObject);

        /** @var array<mixed, mixed> */
        return json_decode($json, true);
    }

    /**
     * @param array<mixed, mixed>  $data
     *
     * @return Collection<LawBookStruct>
     */
    private function parseDataToStruct(array $data): Collection
    {
        $lawBookStructCollection = new Collection();
        foreach ($data['wetgeving']['wet-besluit']['wettekst'] as $chapter => $chapterData) {
            dd($chapter, $chapterData);
            foreach ($chapterData as $key => $item) {
//                dd($key);
                $law = match ($key) {
//                    'artikel' => dd($key),
                    'artikel' => $this->hydrateLawBookStructKop($item),
                    default   => null,
                };
                if (! $law) {
                    continue;
                }
                $lawBookStructCollection->add($law);
            }
        }
        return $lawBookStructCollection;
//        dd($data);
    }

    private function hydrateLawBookStructKop(array $kopData): ?LawBookStruct
    {
        $lawBookStruct = new LawBookStruct();
        foreach ($kopData as $key => $value) {
            dd($key, $value);
            dump(Arr::get($value, 'kop'));
            $lawBookStruct->$key = $value;
        }
        return $lawBookStruct;
    }
}
