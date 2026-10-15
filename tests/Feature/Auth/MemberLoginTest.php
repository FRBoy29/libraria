<?php

namespace Tests\Feature\Auth;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_member_login_page(): void
    {
        $this->get('/member/login')
            ->assertStatus(200);
    }

    public function test_member_can_login_with_correct_member_code_and_password(): void
    {
        $member = Member::factory()->create([
            'member_code' => 'LIB-000123',
            'password' => 'password',
            'status' => 'active',
            'active_until' => now()->addYear(),
        ]);

        Livewire::test('member.auth.login')
            ->set('member_code', 'LIB-000123')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/member/dashboard');

        $this->assertAuthenticatedAs($member, 'member');
    }

    public function test_member_cannot_login_with_wrong_password(): void
    {
        Member::factory()->create([
            'member_code' => 'LIB-000123',
            'password' => 'password',
        ]);

        Livewire::test('member.auth.login')
            ->set('member_code', 'LIB-000123')
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors('password');

        $this->assertGuest('member');
    }

    public function test_member_cannot_login_with_nonexistent_member_code(): void
    {
        Livewire::test('member.auth.login')
            ->set('member_code', 'LIB-999999')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors('member_code');

        $this->assertGuest('member');
    }

    public function test_inactive_member_cannot_login(): void
    {
        Member::factory()->create([
            'member_code' => 'LIB-000123',
            'password' => 'password',
            'status' => 'inactive',
        ]);

        Livewire::test('member.auth.login')
            ->set('member_code', 'LIB-000123')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors('member_code');

        $this->assertGuest('member');
    }

    public function test_expired_member_cannot_login(): void
    {
        Member::factory()->create([
            'member_code' => 'LIB-000123',
            'password' => 'password',
            'status' => 'active',
            'active_until' => now()->subDay(),
        ]);

        Livewire::test('member.auth.login')
            ->set('member_code', 'LIB-000123')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors('member_code');

        $this->assertGuest('member');
    }

    public function test_member_login_requires_member_code_field(): void
    {
        Livewire::test('member.auth.login')
            ->set('member_code', '')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors('member_code');
    }

    public function test_member_login_requires_password_field(): void
    {
        Livewire::test('member.auth.login')
            ->set('member_code', 'LIB-000123')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors('password');
    }

    public function test_member_can_logout(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member');

        $this->post('/member/logout')
            ->assertRedirect('/member/login');

        $this->assertGuest('member');
    }

    public function test_guest_cannot_access_member_dashboard(): void
    {
        $this->get('/member/dashboard')
            ->assertRedirect('/member/login');
    }

    public function test_guest_cannot_access_member_books(): void
    {
        $this->get('/member/books')
            ->assertRedirect('/member/login');
    }

    public function test_guest_cannot_access_member_borrowings(): void
    {
        $this->get('/member/borrowings')
            ->assertRedirect('/member/login');
    }

    public function test_guest_cannot_access_member_history(): void
    {
        $this->get('/member/history')
            ->assertRedirect('/member/login');
    }

    public function test_guest_cannot_access_member_profile(): void
    {
        $this->get('/member/profile')
            ->assertRedirect('/member/login');
    }

    public function test_authenticated_member_redirected_away_from_login(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member')
            ->get('/member/login')
            ->assertRedirect('/member/dashboard');
    }
}
