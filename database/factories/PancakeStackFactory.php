<?php

namespace Database\Factories;

use App\Models\PancakeStack;
use Illuminate\Database\Eloquent\Factories\Factory;

class PancakeStackFactory extends Factory
{
    protected $model = PancakeStack::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
