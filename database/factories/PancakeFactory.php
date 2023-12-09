<?php

namespace Database\Factories;

use App\Models\Pancake;
use Illuminate\Database\Eloquent\Factories\Factory;

class PancakeFactory extends Factory
{
    protected $model = Pancake::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'diameter' => $this->faker->numberBetween(5, 40),
        ];
    }
}
