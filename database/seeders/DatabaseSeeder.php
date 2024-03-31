<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tarea;
use App\Models\User;
use Database\Factories\TareaFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AsignarRolesPermisosSeeder::class,
            EstadoSeeder::class,
            UserSeeder::class,
        ]);


        User::factory()->times(200)->create();
        Tarea::factory()->times(200)->create();
    }
}
