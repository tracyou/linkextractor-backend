<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\ArticleRevision;

class ArticleRevisionObserver
{
    public function creating(ArticleRevision $model): void
    {
        $model->revision = $model->article->law->revision + 1;
    }
}
