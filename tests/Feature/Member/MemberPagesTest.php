<?php

namespace Tests\Feature\Member;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberPagesTest extends TestCase
{
    use RefreshDatabase;

    private Member $member;

    private Book $book;

    protected function setUp(): void
    {
        parent::setUp();
        $this->member = Member::factory()->create();
        $this->book = Book::factory()->create([
            'category_id' => Category::factory()->create()->id,
        ]);
    }

    public function test_member_can_see_dashboard(): void
    {
        $this->actingAs($this->member, 'member')
            ->get('/member/dashboard')
            ->assertStatus(200);
    }

    public function test_member_dashboard_shows_own_data(): void
    {
        // Create a borrowing for this member
        $borrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $borrowing->id,
            'book_id' => $this->book->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        $this->actingAs($this->member, 'member')
            ->get('/member/dashboard')
            ->assertStatus(200);
    }

    public function test_member_can_see_catalog(): void
    {
        $this->actingAs($this->member, 'member')
            ->get('/member/books')
            ->assertStatus(200);
    }

    public function test_member_catalog_shows_books(): void
    {
        Book::factory()->create(['title' => 'Atomic Habits']);

        Livewire::actingAs($this->member, 'member')
            ->test('member.catalog')
            ->assertStatus(200);
    }

    public function test_member_can_search_catalog(): void
    {
        Book::factory()->create(['title' => 'Laskar Pelangi']);
        Book::factory()->create(['title' => 'Sapiens']);

        Livewire::actingAs($this->member, 'member')
            ->test('member.catalog')
            ->set('search', 'Laskar')
            ->assertSee('Laskar Pelangi')
            ->assertDontSee('Sapiens');
    }

    public function test_member_can_filter_catalog_by_category(): void
    {
        $cat1 = Category::factory()->create();
        $cat2 = Category::factory()->create();

        Book::factory()->create(['title' => 'Book A', 'category_id' => $cat1->id]);
        Book::factory()->create(['title' => 'Book B', 'category_id' => $cat2->id]);

        Livewire::actingAs($this->member, 'member')
            ->test('member.catalog')
            ->set('filterCategory', (string) $cat1->id)
            ->assertSee('Book A')
            ->assertDontSee('Book B');
    }

    public function test_member_can_see_book_detail(): void
    {
        $book = Book::factory()->create();

        $this->actingAs($this->member, 'member')
            ->get("/member/books/{$book->id}")
            ->assertStatus(200);
    }

    public function test_member_can_see_my_borrowings(): void
    {
        $this->actingAs($this->member, 'member')
            ->get('/member/activity')
            ->assertStatus(200);

        // Old URL redirects to the merged activity page.
        $this->actingAs($this->member, 'member')
            ->get('/member/borrowings')
            ->assertRedirect('/member/activity');
    }

    public function test_member_my_borrowings_shows_only_own(): void
    {
        $otherMember = Member::factory()->create();

        // My borrowing
        $myBorrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ]);
        BorrowingDetail::create([
            'borrowing_id' => $myBorrowing->id,
            'book_id' => $this->book->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        // Other member's borrowing
        $otherBorrowing = Borrowing::create([
            'member_id' => $otherMember->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ]);
        $otherBook = Book::factory()->create();
        BorrowingDetail::create([
            'borrowing_id' => $otherBorrowing->id,
            'book_id' => $otherBook->id,
            'quantity' => 1,
            'status' => 'borrowed',
        ]);

        $component = Livewire::actingAs($this->member, 'member')
            ->test('member.activity')
            ->assertSee($this->book->title)
            ->assertDontSee($otherBook->title);

        // Verify data isolation
        $this->assertDatabaseHas('borrowings', ['id' => $myBorrowing->id, 'member_id' => $this->member->id]);
        $this->assertDatabaseHas('borrowings', ['id' => $otherBorrowing->id, 'member_id' => $otherMember->id]);
    }

    public function test_member_can_see_history(): void
    {
        $this->actingAs($this->member, 'member')
            ->get('/member/activity')
            ->assertStatus(200);

        // Old URL redirects to the merged activity page.
        $this->actingAs($this->member, 'member')
            ->get('/member/history')
            ->assertRedirect('/member/activity');
    }

    public function test_member_history_shows_only_own_returned_books(): void
    {
        $otherMember = Member::factory()->create();

        // My returned borrowing
        $myBorrowing = Borrowing::create([
            'member_id' => $this->member->id,
            'borrowed_at' => now()->subDays(10)->toDateString(),
            'due_at' => now()->subDays(3)->toDateString(),
            'status' => 'returned',
        ]);
        $myDetail = BorrowingDetail::create([
            'borrowing_id' => $myBorrowing->id,
            'book_id' => $this->book->id,
            'quantity' => 1,
            'returned_at' => now()->subDays(5),
            'status' => 'returned',
        ]);

        // Other member's returned borrowing
        $otherBorrowing = Borrowing::create([
            'member_id' => $otherMember->id,
            'borrowed_at' => now()->subDays(10)->toDateString(),
            'due_at' => now()->subDays(3)->toDateString(),
            'status' => 'returned',
        ]);
        $otherBook = Book::factory()->create();
        BorrowingDetail::create([
            'borrowing_id' => $otherBorrowing->id,
            'book_id' => $otherBook->id,
            'quantity' => 1,
            'returned_at' => now()->subDays(5),
            'status' => 'returned',
        ]);

        $component = Livewire::actingAs($this->member, 'member')
            ->test('member.activity')
            ->set('tab', 'history')
            ->assertSee($this->book->title)
            ->assertDontSee($otherBook->title);

        // Verify data isolation
        $this->assertDatabaseHas('borrowing_details', ['id' => $myDetail->id, 'status' => 'returned']);
    }

    public function test_member_can_see_profile(): void
    {
        $this->actingAs($this->member, 'member')
            ->get('/member/profile')
            ->assertStatus(200);
    }

    public function test_member_can_download_member_card_pdf(): void
    {
        $component = Livewire::actingAs($this->member, 'member')
            ->test('member.profile')
            ->call('downloadCard')
            ->assertFileDownloaded('kartu-anggota-' . $this->member->member_code . '.pdf');

        $content = base64_decode(data_get($component->effects, 'download.content'));
        $this->assertStringStartsWith('%PDF', $content);
    }

    public function test_member_can_update_profile_email(): void
    {
        Livewire::actingAs($this->member, 'member')
            ->test('member.profile')
            ->set('email', 'newemail@mail.com')
            ->call('saveProfile')
            ->assertHasNoErrors();

        $this->member->refresh();
        $this->assertSame('newemail@mail.com', $this->member->email);
    }

    public function test_member_can_update_profile_phone(): void
    {
        Livewire::actingAs($this->member, 'member')
            ->test('member.profile')
            ->set('phone', '08123456789')
            ->call('saveProfile')
            ->assertHasNoErrors();

        $this->member->refresh();
        $this->assertSame('08123456789', $this->member->phone);
    }

    public function test_member_can_update_profile_address(): void
    {
        Livewire::actingAs($this->member, 'member')
            ->test('member.profile')
            ->set('address', 'Jalan Baru No. 123')
            ->call('saveProfile')
            ->assertHasNoErrors();

        $this->member->refresh();
        $this->assertSame('Jalan Baru No. 123', $this->member->address);
    }

    public function test_member_can_change_password(): void
    {
        Livewire::actingAs($this->member, 'member')
            ->test('member.profile')
            ->set('current_password', 'password')
            ->set('new_password', 'newpassword')
            ->set('new_password_confirmation', 'newpassword')
            ->call('changePassword')
            ->assertHasNoErrors();

        $this->member->refresh();
        $this->assertTrue(password_verify('newpassword', $this->member->password));
    }

    public function test_member_cannot_change_password_with_wrong_current_password(): void
    {
        Livewire::actingAs($this->member, 'member')
            ->test('member.profile')
            ->set('current_password', 'wrong-password')
            ->set('new_password', 'newpassword')
            ->set('new_password_confirmation', 'newpassword')
            ->call('changePassword')
            ->assertHasErrors('current_password');

        $this->member->refresh();
        $this->assertFalse(password_verify('newpassword', $this->member->password));
    }

    public function test_new_password_must_be_confirmed(): void
    {
        Livewire::actingAs($this->member, 'member')
            ->test('member.profile')
            ->set('current_password', 'password')
            ->set('new_password', 'newpassword')
            ->set('new_password_confirmation', 'different')
            ->call('changePassword')
            ->assertHasErrors('new_password');
    }
}
