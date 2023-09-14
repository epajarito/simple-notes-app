<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = fake()->sentence,
            'slug' => str($title)->slug(),
            'content' => fake()->paragraphs(5, asText: true),
            'favorite' => rand(0,1),
            'created_at' => $date = fake()->dateTimeBetween('-3 months', '-1 week'),
            'updated_at' => $date
        ];
    }
}
