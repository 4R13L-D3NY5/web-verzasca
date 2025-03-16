<?php

namespace Database\Factories;

use App\Models\Base;
use App\Models\Enbotellado; // Importa el modelo relacionado
use App\Models\Tapa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'imagen' => $this->faker->imageUrl(200, 200),
            'tipoContenido' => $this->faker->numberBetween(1, 5),
            'tipoProducto' => $this->faker->boolean,
            'capacidad' => $this->faker->numberBetween(500, 2000),
            'precioReferencia' => $this->faker->randomFloat(2, 1, 100),
            'observaciones' => $this->faker->optional()->sentence,
            'estado' => $this->faker->boolean,
            'base_id' => Base::get()->random()->id,
            'tapa_id' => Tapa::get()->random()->id,
            // 'cantidad' => $this->faker->numberBetween(10, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
