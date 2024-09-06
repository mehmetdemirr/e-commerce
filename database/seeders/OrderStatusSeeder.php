<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::insert([
            ['name' => 'Pending', 'description' => 'Sipariş henüz işleme alınmamış.'],
            ['name' => 'Processing', 'description' => 'Sipariş işleme alınıyor.'],
            ['name' => 'Shipped', 'description' => 'Sipariş gönderildi.'],
            ['name' => 'Delivered', 'description' => 'Sipariş teslim edildi.'],
            ['name' => 'Cancelled', 'description' => 'Sipariş iptal edildi.'],
            ['name' => 'Returned', 'description' => 'Sipariş geri iade edildi.'],
            ['name' => 'Refunded', 'description' => 'Sipariş için geri ödeme yapıldı.'],
        ]);
    }
}
