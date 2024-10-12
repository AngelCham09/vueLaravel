<?php

namespace Database\Factories;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "purchase_id" => Purchase::factory(),
            'name' => fake()->name,
            'brand' => fake()->unique()->word,
            'price' =>
            $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
