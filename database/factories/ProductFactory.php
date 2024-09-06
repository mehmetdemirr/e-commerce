<?php


namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'quantity' => $this->faker->numberBetween(1, 100),
            'sku' => $this->faker->unique()->ean13(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'business_id' => 2,
            'brand_id' => $this->faker->numberBetween(1, 10),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'shipping_cost' => $this->faker->randomFloat(2, 5, 20),
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'dimensions' => $this->faker->randomElement(['10x10x10', '20x20x20', '30x30x30']),
            'views' => $this->faker->numberBetween(0, 1000),
            'sales' => $this->faker->numberBetween(0, 500),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
