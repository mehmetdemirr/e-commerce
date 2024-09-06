<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(), // Varsayılan bir sipariş oluşturur
            'product_id' => Product::factory(), // Varsayılan bir ürün oluşturur
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(10, 100),
            'deleted_at' => null, // Soft delete için
        ];
    }
}
