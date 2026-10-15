<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ];
    }
}
