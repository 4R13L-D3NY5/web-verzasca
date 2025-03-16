<?php

namespace Database\Factories;

use App\Models\Producto; // Importa el modelo relacionado
use App\Models\Etiqueta; // Importa el modelo relacionad
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fechaElaboracion' => $this->faker->date,
            'fechaVencimiento' => $this->faker->date,
            // 'etiquetas' => $this->faker->imageUrl(100, 100),
            // 'cantidad' => $this->faker->numberBetween(10, 100),
            'observaciones' => $this->faker->optional()->sentence,
            'etiqueta_id' => Producto::get()->random()->id,
            'producto_id' => Etiqueta::get()->random()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
