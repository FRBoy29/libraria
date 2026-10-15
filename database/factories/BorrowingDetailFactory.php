<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BorrowingDetail>
 */
class BorrowingDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'borrowing_id' => Borrowing::factory(),
            'book_id' => Book::factory(),
            'quantity' => 1,
            'returned_at' => null,
            'status' => 'borrowed',
        ];
    }
}
