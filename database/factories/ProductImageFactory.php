<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id, // Rastgele bir ürün ID'si
            'image_url' => $this->faker->imageUrl(),
            'is_main' => false, // Varsayılan olarak false
        ];
    }

    /**
     * Sadece bir ürün resmi için is_main değerini true yapacak state.
     */
    public function main()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_main' => true,
            ];
        });
    }
}
