<?php

namespace Database\Seeders;
use App\Models\Cliente; 
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario con la contraseña '12345678' hasheada
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),  // Hasheamos la contraseña
        ]);
        Cliente::factory(5)->create();
    }
}
