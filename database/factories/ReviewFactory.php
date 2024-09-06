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
        // Kullanıcıları ve ürünleri al
        $users = User::all();

        // Eğer kullanıcılar yoksa, factory boş bir dizi döndürür
        if ($users->isEmpty()) {
            return [];
        }

        // Rastgele bir kullanıcı seç
        $user = $users->random();

        // Kullanıcının satın aldığı ürünleri al
        $products = OrderItem::where('order_id', function($query) use ($user) {
            $query->select('id')
                ->from('orders')
                ->where('user_id', $user->id);
        })->pluck('product_id');

        // Eğer kullanıcı hiçbir ürün satın almadıysa, factory boş bir dizi döndürür
        if ($products->isEmpty()) {
            return [];
        }

        // Rastgele bir ürün seç
        $productId = $products->random();

        return [
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
        ];
    }
}
