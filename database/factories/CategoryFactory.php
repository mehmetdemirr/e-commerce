<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'parent_id' => null, // Varsayılan olarak üst kategori yok
        ];
    }

    /**
     * Üst kategoriler oluşturmak için parent_id'yi ayarlayan state.
     */
    public function withParent($parentId)
    {
        return $this->state(function () use ($parentId) {
            return [
                'parent_id' => $parentId,
            ];
        });
    }
}
