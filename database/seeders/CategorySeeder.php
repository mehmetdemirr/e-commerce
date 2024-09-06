<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 ana kategori oluştur
        $parentCategories = Category::factory()->count(5)->create();

        // Her ana kategori için 3 ila 5 alt kategori oluştur
        foreach ($parentCategories as $parentCategory) {
            Category::factory()->count(rand(3, 5))->withParent($parentCategory->id)->create();
        }

        // Ayrıca, rastgele alt kategoriler oluştur
        // Bu, bazı ana kategorilerin alt kategorilere sahip olmasını sağlar
        Category::factory()->count(10)->create();
    }
}
