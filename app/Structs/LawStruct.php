<?php

declare(strict_types=1);

namespace App\Structs;

use App\Models\Article;
use App\Models\Law;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Boolean;

final class LawStruct
{
    /** @param ArticleStruct[]  $articles */
    public function __construct(
        private string $title,
        private bool $isPublished,
        private array $articles = [],
    ) {
    }

    public function add(ArticleStruct $article): void
    {
        $this->articles[] = $article;
    }

    public function remove(int $key): void
    {
        Arr::pull($this->articles, $key);
    }

    public function save(): Law
    {
        $law = Law::firstOrCreate(['title' => $this->title]);
        foreach ($this->articles as $article) {
            $model = $article->toModel();
            if (!$model) {
                continue;
            }

            if (Article::findDuplicated($model->title, $law->id)->exists()) {
                continue;
            }

            $model->law()->associate($law);
            $model->save();
        }

        return $law;
    }
}
