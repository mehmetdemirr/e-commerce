<?php

namespace Database\Seeders;

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
        // Ürünlerin ve kullanıcıların mevcut olduğundan emin ol
        if (Product::count() == 0 || User::count() == 0) {
            $this->command->info('No products or users found. Please run ProductSeeder and UserSeeder first.');
            return;
        }

        Review::factory()->count(50)->create();
    }
}
