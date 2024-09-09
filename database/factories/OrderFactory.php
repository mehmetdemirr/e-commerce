<?php

namespace Database\Factories;

use App\Enum\OrderStatusEnum;
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
            'order_status_id' => OrderStatusEnum::PENDING,
            'payment_status_id' => $this->faker->numberBetween(1, 5), 
            'total' => $this->faker->numberBetween(100, 500),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'cod']), // Ödeme yöntemi örnekleri
            'payment_reference' => $this->faker->uuid(), // Ödeme referansı için UUID
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
