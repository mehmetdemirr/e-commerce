<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eğer veritabanında ürün yoksa hata verdir
        if (Product::count() === 0) {
            throw new \Exception('Ürün eklenmeden cart item oluşturulamaz!');
        }

        // Tüm sepetleri al
        
        $carts = Cart::all();
        // Her sepet için rastgele sayıda ürün oluştur
        foreach ($carts as $cart) {
            CartItem::factory()
                ->count(rand(5, 10))
                ->create(['cart_id' => $cart->id]);
        }
    }
}
