<?php

namespace App\Models;

use App\Factories\FileXmlFactory;
use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Annotation
 *
 * @property string                    $id
 * @property string                    $title
 * @property string                    $content
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property Carbon|null               $deleted_at

 * @method static FileXmlFactory factory($count = null, $state = [])

 * @mixin Eloquent
 */
class FileXml extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
    ];
}
