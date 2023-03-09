<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MateriasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->sentence(),
            'codigo' => fake()->bothify('???####'), 
            'creditos' => fake()->numberBetween(1, 15),
            'descripcion' => fake()->paragraph(2),
        ];
    }
}
