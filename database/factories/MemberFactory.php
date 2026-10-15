<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'member_code' => 'LIB-' . str_pad((string) fake()->unique()->randomNumber(6), 6, '0', STR_PAD_LEFT),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'phone' => fake()->numerify('08##########'),
            'address' => fake()->address(),
            'status' => 'active',
            'active_until' => now()->addYear(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['status' => 'inactive']);
    }

    public function expired(): static
    {
        return $this->state(fn () => ['active_until' => now()->subDay()]);
    }
}
