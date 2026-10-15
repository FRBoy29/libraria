<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_admin_login_page(): void
    {
        $this->get('/admin/login')
            ->assertStatus(200);
    }

    public function test_admin_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@libraria.local',
            'password' => 'password',
        ]);

        Livewire::test('admin.auth.login')
            ->set('email', 'admin@libraria.local')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/admin/dashboard');

        $this->assertAuthenticatedAs($user, 'web');
    }

    public function test_admin_cannot_login_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'admin@libraria.local',
            'password' => 'password',
        ]);

        Livewire::test('admin.auth.login')
            ->set('email', 'admin@libraria.local')
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors('email');

        $this->assertGuest('web');
    }

    public function test_admin_cannot_login_with_nonexistent_email(): void
    {
        Livewire::test('admin.auth.login')
            ->set('email', 'nobody@libraria.local')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors('email');

        $this->assertGuest('web');
    }

    public function test_admin_login_requires_email_field(): void
    {
        Livewire::test('admin.auth.login')
            ->set('email', '')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors('email');
    }

    public function test_admin_login_requires_password_field(): void
    {
        Livewire::test('admin.auth.login')
            ->set('email', 'admin@libraria.local')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors('password');
    }

    public function test_admin_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web');

        $this->post('/admin/logout')
            ->assertRedirect('/admin/login');

        $this->assertGuest('web');
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get('/admin/dashboard')
            ->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_admin_books(): void
    {
        $this->get('/admin/books')
            ->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_admin_categories(): void
    {
        $this->get('/admin/categories')
            ->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_admin_members(): void
    {
        $this->get('/admin/members')
            ->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_admin_borrowings(): void
    {
        $this->get('/admin/borrowings')
            ->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_admin_returns(): void
    {
        $this->get('/admin/returns')
            ->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_admin_reports(): void
    {
        $this->get('/admin/reports')
            ->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_redirected_away_from_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web')
            ->get('/admin/login')
            ->assertRedirect('/admin/dashboard');
    }
}
