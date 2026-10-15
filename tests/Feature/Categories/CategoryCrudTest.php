<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_see_categories_list(): void
    {
        $this->actingAs($this->admin, 'web')
            ->get('/admin/categories')
            ->assertStatus(200);
    }

    public function test_admin_can_create_category(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('category.manager')
            ->set('name', 'Fiksi')
            ->set('description', 'Novel dan cerita fiksi')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'name' => 'Fiksi',
            'description' => 'Novel dan cerita fiksi',
        ]);
    }

    public function test_category_name_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('category.manager')
            ->set('name', '')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_admin_can_edit_category(): void
    {
        $category = Category::factory()->create(['name' => 'Sains']);

        Livewire::actingAs($this->admin, 'web')
            ->test('category.manager')
            ->call('edit', $category->id)
            ->set('name', 'Sains Terapan')
            ->call('save')
            ->assertHasNoErrors();

        $category->refresh();

        $this->assertSame('Sains Terapan', $category->name);
    }

    public function test_admin_can_delete_category(): void
    {
        $category = Category::factory()->create();

        Livewire::actingAs($this->admin, 'web')
            ->test('category.manager')
            ->call('delete', $category->id);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_search_categories(): void
    {
        Category::factory()->create(['name' => 'Fiksi']);
        Category::factory()->create(['name' => 'Sains']);

        Livewire::actingAs($this->admin, 'web')
            ->test('category.manager')
            ->set('search', 'Fiksi')
            ->assertSee('Fiksi')
            ->assertDontSee('Sains');
    }
}
