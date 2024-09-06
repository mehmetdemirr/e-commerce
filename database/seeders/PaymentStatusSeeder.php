<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentStatus::insert([
            ['name' => 'Pending', 'description' => 'Ödeme henüz alınmadı veya işleme alınmadı.'],
            ['name' => 'Completed', 'description' => 'Ödeme tamamlandı.'],
            ['name' => 'Failed', 'description' => 'Ödeme işlemi başarısız oldu.'],
            ['name' => 'Refunded', 'description' => 'Ödeme geri ödendi.'],
            ['name' => 'Cancelled', 'description' => 'Ödeme işlemi iptal edildi.'],
        ]);
    }
}
