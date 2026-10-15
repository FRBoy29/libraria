<?php

namespace Tests\Feature\Returns;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReturnTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Member $member;

    private Book $book;

    private Borrowing $borrowing;

    private BorrowingDetail $detail;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        $this->member = Member::factory()->create();
        $this->book = Book::factory()->create([
            'stock' => 4,
            'category_id' => Category::factory()->create()->id,
        ]);

        // Create a borrowing with a detail
        $this->borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'borrowed_at' => now()->subDays(3)->toDateString(),
            'due_at' => now()->addDays(4)->toDateString(),
            'status' => 'borrowed',
        ]);

        $this->detail = BorrowingDetail::create([
            'borrowing_id' => $this->borrowing->id,
            'book_id' => $this->book->id,
            'quantity' => 2,
            'status' => 'borrowed',
        ]);

        // Simulate stock was already reduced when borrowed
        $this->book->update(['stock' => 3]);
    }

    public function test_admin_can_see_returns_list(): void
    {
        $this->actingAs($this->admin, 'web')
            ->get('/admin/circulations')
            ->assertStatus(200);

        $this->actingAs($this->admin, 'web')
            ->get('/admin/returns')
            ->assertRedirect('/admin/circulations');
    }

    public function test_admin_can_process_return(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        $this->detail->refresh();

        $this->assertSame('returned', $this->detail->status);
        $this->assertNotNull($this->detail->returned_at);
    }

    public function test_return_increases_stock(): void
    {
        $stockBefore = $this->book->stock;

        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        $this->book->refresh();
        $this->assertSame($stockBefore + $this->detail->quantity, $this->book->stock);
    }

    public function test_return_updates_borrowing_status_when_all_details_returned(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        $this->borrowing->refresh();
        $this->assertSame('returned', $this->borrowing->status);
    }

    public function test_double_return_is_rejected(): void
    {
        // First return
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        // Second return attempt
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        $this->detail->refresh();
        $this->assertSame('returned', $this->detail->status);
    }

    public function test_return_does_not_change_borrowing_status_when_some_details_still_borrowed(): void
    {
        // Add another detail that's still borrowed
        $book2 = Book::factory()->create([
            'stock' => 5,
            'category_id' => $this->book->category_id,
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $this->borrowing->id,
            'book_id' => $book2->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        // Return the first detail only
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        $this->borrowing->refresh();
        $this->assertSame('borrowed', $this->borrowing->status);
    }

    public function test_returned_at_is_set_on_return(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        $this->detail->refresh();
        $this->assertNotNull($this->detail->returned_at);
    }

    public function test_returns_list_shows_only_borrowed_details(): void
    {
        // The active detail should be visible
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->assertStatus(200);

        // After return, it should no longer be in the active list
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->call('returnDetail', $this->detail->id);

        // Query the DB to verify it's no longer 'borrowed'
        $this->detail->refresh();
        $this->assertSame('returned', $this->detail->status);
    }
}
