<?php

namespace Database\Factories;

use App\Models\Matter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Matter>
 */
class MatterFactory extends Factory
{
    protected $model = Matter::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(), //randomElement(['Rechtssubject', 'Rechtsobject', 'Rechtsbetrekking', 'Voorwaarde', 'Rechtsfeit', 'operator', 'afleidingsregel', 'variabele', 'variabele-waarde', 'parameter', 'parameter-waarde', 'tijdsaanduiding', 'plaatsaanduiding']),
            'color' => fake()->unique()->safeHexColor,
        ];
    }
}
