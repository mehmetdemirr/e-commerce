<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

       $user = User::factory()->create([
            'name' => 'Mehmet',
            'email' => 'mehmet@gmail.com',
        ]);

        $user->assignRole('admin');

        $this->call([
            CategorySeeder::class, //genel kategori ekle
            BrandSeeder::class, //genele marka ekle
            UserSeeder::class, //kullanıcı ekle
            ProductSeeder::class, //ürün ekle
            ProductImageSeeder::class, //ürünlere fotoğraf ekle
            CartSeeder::class, //kullanıcıya sepet ekle
            CartItemSeeder::class, //sepete item ekle
            OrderSeeder::class, //sipariş oluştur
            ReviewSeeder::class, //ürünlere yorum ekle
            BusinessSeeder::class, //işletme ekle
        ]); 

    }
}
