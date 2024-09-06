<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       // Yeni bir kullanıcı oluşturup ona 'company' rolü atıyoruz
       $user = User::factory()->create();
       $user->assignRole('company');

       return [
           'user_id' => $user->id,
           'iban' => $this->faker->iban(),
           'address' => $this->faker->address(),
           'contact_info' => $this->faker->phoneNumber(),
       ];
    }
}
