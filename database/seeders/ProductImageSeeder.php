<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Ürünler oluşturulmadan önce ürünlerin mevcut olduğundan emin ol
       $products = Product::all();

       // Eğer ürünler mevcut değilse, seeder işlemi yapılmaz
       if ($products->isEmpty()) {
           $this->command->info('No products found. Please run ProductSeeder first.');
           return;
       }

       foreach ($products as $product) {
           // Her ürün için bir ana resim oluştur
           ProductImage::factory()->main()->create([
               'product_id' => $product->id,
           ]);

           // Aynı ürün için 3 rastgele resim oluştur
           ProductImage::factory()->count(3)->create([
               'product_id' => $product->id,
           ]);
       }
    }
}
