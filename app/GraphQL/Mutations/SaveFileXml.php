<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\FileXmlFactoryInterface;
use App\Contracts\Repositories\FileXmlRepositoryInterface;
use App\Factories\FileXmlFactory;
use App\Models\FileXml;
use App\Repositories\FileXmlRepository;
use Exception;

class SaveFileXml
{
    public function __construct(
        protected FileXmlFactoryInterface    $fileXmlFactory,
        protected FileXmlRepositoryInterface $fileXmlRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke($_, array $args): FileXml
    {
        $title = $args['title'];
        $content = $args['content'];

        return $this->fileXmlRepository->create([
            'title' => $title,
            'content' => $content
        ]);
    }
}

