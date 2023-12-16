<?php

namespace Database\Factories;

use App\Models\FileXml;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileXmlFactory extends Factory
{

    protected $model = FileXml::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence,
            'content'        => $this->faker->text,
        ];
    }

}
