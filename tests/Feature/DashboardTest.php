<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_displays_real_stats(): void
    {
        $admin = User::factory()->create();

        $category = Category::factory()->create();
        $book1 = Book::factory()->create(['stock' => 5, 'category_id' => $category->id]);
        $book2 = Book::factory()->create(['stock' => 3, 'category_id' => $category->id]);

        $member = Member::factory()->create();

        // Active borrowing
        $activeBorrowing = Borrowing::create([
            'member_id' => $member->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $activeBorrowing->id,
            'book_id' => $book1->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        // Overdue borrowing
        $overdueBorrowing = Borrowing::create([
            'member_id' => $member->id,
            'borrowed_at' => now()->subDays(10)->toDateString(),
            'due_at' => now()->subDays(3)->toDateString(),
            'status' => 'borrowed',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $overdueBorrowing->id,
            'book_id' => $book2->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        // Returned borrowing
        $returnedBorrowing = Borrowing::create([
            'member_id' => $member->id,
            'borrowed_at' => now()->subDays(15)->toDateString(),
            'due_at' => now()->subDays(8)->toDateString(),
            'status' => 'returned',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $returnedBorrowing->id,
            'book_id' => $book1->id,
            'quantity' => 1,
            'returned_at' => now()->subDays(9),
            'status' => 'returned',
        ]);

        $component = \Livewire\Livewire::actingAs($admin, 'web')
            ->test('dashboard.stats');

        // Total stock = 5 + 3 = 8
        $this->assertSame(8, $component->viewData('availableStock'));
        // Total titles = 2
        $this->assertSame(2, $component->viewData('totalTitles'));
        // Borrowed qty = 2 (1 from active + 1 from overdue)
        $this->assertSame(2, $component->viewData('borrowedQty'));
        // Active members = 1
        $this->assertSame(1, $component->viewData('activeMembers'));
        // Overdue borrowings = 1
        $this->assertSame(1, $component->viewData('overdueCount'));
    }

    public function test_admin_dashboard_empty_state(): void
    {
        $admin = User::factory()->create();

        $component = \Livewire\Livewire::actingAs($admin, 'web')
            ->test('dashboard.stats');

        $this->assertSame(0, $component->viewData('availableStock'));
        $this->assertSame(0, $component->viewData('totalTitles'));
        $this->assertSame(0, $component->viewData('activeMembers'));
        $this->assertSame(0, $component->viewData('borrowedQty'));
        $this->assertSame(0, $component->viewData('overdueCount'));
    }

    public function test_admin_reports_page_loads(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin, 'web')
            ->get('/admin/reports')
            ->assertStatus(200);
    }
}
