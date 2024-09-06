<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Kullanıcının sipariş verdiği ürünlerden birini seç
        $orderItem = OrderItem::inRandomOrder()->first();

        // Eğer sipariş verilmiş bir ürün yoksa, factory boş döner
        if (!$orderItem) {
            return [];
        }

        return [
            'user_id' => $orderItem->order->user_id, // Siparişi veren kullanıcı
            'product_id' => $orderItem->product_id,  // Sipariş edilen ürün
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence,
        ];
    }
}
