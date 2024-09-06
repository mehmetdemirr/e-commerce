<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tüm kullanıcıları al
        $users = User::all();

        // Her kullanıcı için bir sepet oluştur
        foreach ($users as $user) {
            // Kullanıcı için sepet oluştur
            Cart::updateOrCreate(
                ['user_id' => $user->id], // Benzersiz anahtar olarak user_id
                ['user_id' => $user->id]   // Sepet verileri
            );
        }
    }
}
