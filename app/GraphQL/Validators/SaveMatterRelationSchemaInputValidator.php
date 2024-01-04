<?php

declare(strict_types=1);

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

class SaveMatterRelationSchemaInputValidator extends Validator
{
    public function rules(): array
    {
        return [
            'matterId'                    => ['exists:matters,id'],
            'relationSchemaId'            => [
                'nullable',
                'exists:relation_schemas,id',
            ],
            'matterRelationSchemaId'      => [
                'nullable',
                'exists:matter_relation_schemas,id',
            ],
            'relations.*.relatedMatterId' => [
                'exists:matters,id',
                Rule::notIn([$this->arg('matterId')]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'relations.*.relatedMatterId.not_in' => 'The related matter id cannot be the same as the matter id.',
        ];
    }
}
