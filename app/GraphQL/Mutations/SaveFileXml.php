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
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke($_, array $args): FileXml
    {
        // get the values form the endpoint
        $title = $args['title'];
        $content = $args['content'];

        return $this->fileXmlFactory->create($title,$content);
    }
}
