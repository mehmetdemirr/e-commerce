<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Doğrudan bir ürün seç, boş dönerse hata fırlatır
        $product = Product::inRandomOrder()->firstOrFail();

        return [
            'cart_id' => null, // Sepet ID'si seeder'dan gelecek
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
