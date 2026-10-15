<?php

namespace Tests\Feature\Borrowings;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BorrowingTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Member $member;

    private Book $book;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        $this->member = Member::factory()->create();
        $this->book = Book::factory()->create([
            'stock' => 5,
            'category_id' => Category::factory()->create()->id,
        ]);
    }

    public function test_admin_can_see_borrowings_list(): void
    {
        $this->actingAs($this->admin, 'web')
            ->get('/admin/circulations')
            ->assertStatus(200);

        $this->actingAs($this->admin, 'web')
            ->get('/admin/borrowings')
            ->assertRedirect('/admin/circulations');
    }

    public function test_admin_can_create_borrowing(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', (string) $this->member->id)
            ->set('book_id', (string) $this->book->id)
            ->set('quantity', 1)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('borrowings', [
            'member_id' => $this->member->id,
            'status' => 'borrowed',
        ]);

        $this->assertDatabaseHas('borrowing_details', [
            'book_id' => $this->book->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        // Stock should be reduced
        $this->book->refresh();
        $this->assertSame(4, $this->book->stock);
    }

    public function test_borrowing_with_sufficient_stock_reduces_stock(): void
    {
        $book = Book::factory()->create(['stock' => 3]);

        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', (string) $this->member->id)
            ->set('book_id', (string) $book->id)
            ->set('quantity', 2)
            ->call('save')
            ->assertHasNoErrors();

        $book->refresh();
        $this->assertSame(1, $book->stock);
    }

    public function test_borrowing_with_zero_stock_is_rejected(): void
    {
        $book = Book::factory()->create(['stock' => 0]);

        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', (string) $this->member->id)
            ->set('book_id', (string) $book->id)
            ->set('quantity', 1)
            ->call('save')
            ->assertHasErrors('book_id');

        $this->assertDatabaseMissing('borrowings', [
            'member_id' => $this->member->id,
        ]);

        $book->refresh();
        $this->assertSame(0, $book->stock);
    }

    public function test_borrowing_quantity_exceeding_stock_is_rejected(): void
    {
        $book = Book::factory()->create(['stock' => 2]);

        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', (string) $this->member->id)
            ->set('book_id', (string) $book->id)
            ->set('quantity', 5)
            ->call('save')
            ->assertHasErrors('book_id');

        $book->refresh();
        $this->assertSame(2, $book->stock);
    }

    public function test_borrowing_requires_member(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', '')
            ->set('book_id', (string) $this->book->id)
            ->call('save')
            ->assertHasErrors('member_id');
    }

    public function test_borrowing_requires_book(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', (string) $this->member->id)
            ->set('book_id', '')
            ->call('save')
            ->assertHasErrors('book_id');
    }

    public function test_due_at_must_be_after_or_equal_borrowed_at(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', (string) $this->member->id)
            ->set('book_id', (string) $this->book->id)
            ->set('borrowed_at', '2026-09-21')
            ->set('due_at', '2026-09-20')
            ->call('save')
            ->assertHasErrors('due_at');
    }

    public function test_borrowing_transaction_is_atomic(): void
    {
        // If stock check fails, no borrowing should be persisted
        $book = Book::factory()->create(['stock' => 1]);

        Livewire::actingAs($this->admin, 'web')
            ->test('circulation.manager')
            ->set('member_id', (string) $this->member->id)
            ->set('book_id', (string) $book->id)
            ->set('quantity', 5)
            ->call('save')
            ->assertHasErrors('book_id');

        // No borrowing record should exist
        $this->assertDatabaseMissing('borrowings', [
            'member_id' => $this->member->id,
        ]);

        // No borrowing_detail record should exist
        $this->assertDatabaseMissing('borrowing_details', [
            'book_id' => $book->id,
        ]);

        // Stock should remain unchanged
        $book->refresh();
        $this->assertSame(1, $book->stock);
    }
}
