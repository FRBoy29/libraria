<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->sentence(4),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'publication_year' => fake()->numberBetween(1990, (int) date('Y')),
            'stock' => fake()->numberBetween(1, 10),
            'description' => fake()->paragraph(),
            'cover' => null,
        ];
    }
}
