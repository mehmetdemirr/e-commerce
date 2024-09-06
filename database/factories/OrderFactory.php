<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'business_id' => $this->faker->numberBetween(1, 10), // Varsayılan bir işyeri ID'si
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
            'total' => $this->faker->numberBetween(100, 500),
            'deleted_at' => null, // Soft delete için
        ];
    }

    /**
     * İlişkili OrderItem'larla birlikte sipariş oluşturur.
     *
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withItems($count = 3)
    {
        return $this->has(OrderItem::factory()->count($count), 'items');
    }
}
