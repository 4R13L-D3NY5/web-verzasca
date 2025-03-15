<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name, // Nombre del cliente
            'empresa' => $this->faker->company, // Empresa opcional
            'nitCi' => $this->faker->unique()->numerify('########'), // NIT/CI único
            'razonSocial' => $this->faker->companySuffix . " " . $this->faker->company, // Razón social
            'telefono' => $this->faker->numerify('###########'), // Número de teléfono
            'correo' => $this->faker->unique()->safeEmail, // Correo electrónico único

            // Nuevos campos
            'latitud' => $this->faker->latitude(-90, 90), // Latitud aleatoria válida
            'longitud' => $this->faker->longitude(-180, 180), // Longitud aleatoria válida
            'foto' => $this->faker->imageUrl(200, 200, 'people', true, 'Cliente'), // Imagen aleatoria

            'estado' => $this->faker->boolean(80), // Estado (80% activo)
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
