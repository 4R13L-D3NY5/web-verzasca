<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preforma>
 */
class PreformaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'insumo' => $this->faker->word,
            'descripcion' => $this->faker->optional()->sentence,
            'capacidad' => $this->faker->numberBetween(500, 2000),
            'color' => $this->faker->safeColorName,
            'cantidad' => $this->faker->numberBetween(10, 100),
            'estado' => $this->faker->boolean,
            'observaciones' => $this->faker->optional()->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
