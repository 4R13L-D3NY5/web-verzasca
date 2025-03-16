<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tapa>
 */
class TapaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'color' => $this->faker->safeColorName,
            'cantidad' => $this->faker->numberBetween(10, 200),
            'tipo' => $this->faker->randomElement(['rosca', 'botellon']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
