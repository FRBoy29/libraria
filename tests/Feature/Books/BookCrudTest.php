<?php

namespace Tests\Feature\Books;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BookCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    public function test_admin_can_see_books_list(): void
    {
        $this->actingAs($this->admin, 'web')
            ->get('/admin/books')
            ->assertStatus(200);
    }

    public function test_admin_can_create_book(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('isbn', '978-602-001')
            ->set('title', 'Laskar Pelangi')
            ->set('author', 'Andrea Hirata')
            ->set('publisher', 'Bentang')
            ->set('publication_year', 2005)
            ->set('category_id', (string) $this->category->id)
            ->set('stock', 10)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('books', [
            'isbn' => '978-602-001',
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'stock' => 10,
        ]);
    }

    public function test_isbn_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('isbn', '')
            ->call('save')
            ->assertHasErrors('isbn');
    }

    public function test_title_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('title', '')
            ->call('save')
            ->assertHasErrors('title');
    }

    public function test_author_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('author', '')
            ->call('save')
            ->assertHasErrors('author');
    }

    public function test_category_id_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('category_id', '')
            ->call('save')
            ->assertHasErrors('category_id');
    }

    public function test_stock_must_be_non_negative_integer(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('stock', -1)
            ->call('save')
            ->assertHasErrors('stock');
    }

    public function test_isbn_must_be_unique(): void
    {
        Book::factory()->create(['isbn' => '978-602-001']);

        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('isbn', '978-602-001')
            ->set('title', 'Test')
            ->set('author', 'Author')
            ->set('category_id', (string) $this->category->id)
            ->set('stock', 1)
            ->call('save')
            ->assertHasErrors('isbn');
    }

    public function test_admin_can_edit_book(): void
    {
        $book = Book::factory()->create([
            'title' => 'Old Title',
            'category_id' => $this->category->id,
        ]);

        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->call('edit', $book->id)
            ->set('title', 'New Title')
            ->call('save')
            ->assertHasNoErrors();

        $book->refresh();

        $this->assertSame('New Title', $book->title);
    }

    public function test_admin_can_delete_book(): void
    {
        $book = Book::factory()->create();

        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->call('delete', $book->id);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_admin_can_search_books(): void
    {
        Book::factory()->create(['title' => 'Laskar Pelangi']);
        Book::factory()->create(['title' => 'Sapiens']);

        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('search', 'Laskar')
            ->assertSee('Laskar Pelangi')
            ->assertDontSee('Sapiens');
    }

    public function test_admin_can_filter_books_by_category(): void
    {
        $cat1 = Category::factory()->create();
        $cat2 = Category::factory()->create();

        Book::factory()->create(['title' => 'Book A', 'category_id' => $cat1->id]);
        Book::factory()->create(['title' => 'Book B', 'category_id' => $cat2->id]);

        Livewire::actingAs($this->admin, 'web')
            ->test('book.manager')
            ->set('filterCategory', (string) $cat1->id)
            ->assertSee('Book A')
            ->assertDontSee('Book B');
    }
}
