<?php

namespace Tests\Feature\Member;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_a_cannot_see_member_b_borrowings_via_url(): void
    {
        $memberA = Member::factory()->create();
        $memberB = Member::factory()->create();

        $book = Book::factory()->create();

        // Member B has a borrowing
        $borrowingB = Borrowing::create([
            'member_id' => $memberB->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $borrowingB->id,
            'book_id' => $book->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        // Member A logs in and views activity
        $component = \Livewire\Livewire::actingAs($memberA, 'member')
            ->test('member.activity');

        // Member A should see zero borrowings (only own data)
        $activeDetails = $component->viewData('activeDetails');
        $this->assertCount(0, $activeDetails);
    }

    public function test_member_a_cannot_see_member_b_history_via_url(): void
    {
        $memberA = Member::factory()->create();
        $memberB = Member::factory()->create();

        $book = Book::factory()->create();

        // Member B has a returned borrowing
        $borrowingB = Borrowing::create([
            'member_id' => $memberB->id,
            'borrowed_at' => now()->subDays(10)->toDateString(),
            'due_at' => now()->subDays(3)->toDateString(),
            'status' => 'returned',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $borrowingB->id,
            'book_id' => $book->id,
            'quantity' => 1,
            'returned_at' => now()->subDays(5),
            'status' => 'returned',
        ]);

        $component = \Livewire\Livewire::actingAs($memberA, 'member')
            ->test('member.activity')
            ->set('tab', 'history');

        // Member A should see zero history items
        $history = $component->viewData('history');
        $this->assertSame(0, $history->total());
    }

    public function test_member_dashboard_only_shows_own_stats(): void
    {
        $memberA = Member::factory()->create();
        $memberB = Member::factory()->create();

        $book = Book::factory()->create();

        // Member B has an active borrowing
        $borrowingB = Borrowing::create([
            'member_id' => $memberB->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $borrowingB->id,
            'book_id' => $book->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        // Member A views dashboard - should see 0 active borrowings
        $component = \Livewire\Livewire::actingAs($memberA, 'member')
            ->test('member.dashboard');

        $this->assertSame(0, $component->viewData('activeCount'));
        $this->assertSame(0, $component->viewData('overdueCount'));
        $this->assertSame(0, $component->viewData('historyQty'));
    }

    public function test_member_profile_shows_own_data(): void
    {
        $member = Member::factory()->create([
            'email' => 'myemail@mail.com',
            'phone' => '08123456789',
            'address' => 'My Address',
        ]);

        $component = \Livewire\Livewire::actingAs($member, 'member')
            ->test('member.profile');

        $this->assertSame('myemail@mail.com', $component->viewData('member')->email);
        $this->assertSame('08123456789', $component->viewData('member')->phone);
    }

    public function test_member_profile_update_only_affects_own_record(): void
    {
        $memberA = Member::factory()->create([
            'email' => 'memberA@mail.com',
        ]);
        $memberB = Member::factory()->create([
            'email' => 'memberB@mail.com',
        ]);

        \Livewire\Livewire::actingAs($memberA, 'member')
            ->test('member.profile')
            ->set('email', 'newA@mail.com')
            ->call('saveProfile');

        $memberA->refresh();
        $memberB->refresh();

        $this->assertSame('newA@mail.com', $memberA->email);
        $this->assertSame('memberB@mail.com', $memberB->email);
    }
}
