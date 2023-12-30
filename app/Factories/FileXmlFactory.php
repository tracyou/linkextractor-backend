<?php

namespace App\Factories;

use App\Contracts\Factories\FileXmlFactoryInterface;
use App\Models\FileXml;

class FileXmlFactory implements FileXmlFactoryInterface
{

    public function create(string $title, string $content,): FileXml
    {
        $fileXml = new FileXml();
        $fileXml->title = $title;
        $fileXml->text = $content;

        $fileXml->save();
        return $fileXml;
    }
}

