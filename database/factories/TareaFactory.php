<?php

namespace Database\Factories;

use App\Models\Estado;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarea>
 */
class TareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->title('10'),
            'descripcion' => $this->faker->text('100'),
            'estado_id' => Estado::all()->random()->id,
            'user_id' => User::all()->random()->id,
            
        ];
    }
}
