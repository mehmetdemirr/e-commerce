<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Yorumlar, sadece sipariş edilen ürünler için oluşturulacak
        $orderItems = OrderItem::all();

        foreach ($orderItems as $orderItem) {
            Review::factory()->create([
                'user_id' => $orderItem->order->user_id,
                'product_id' => $orderItem->product_id,
            ]);
        }
    }
}
