<?php

namespace Tests\Feature\Auth;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoubleLoginAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_cannot_access_admin_area(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member')
            ->get('/admin/dashboard')
            ->assertRedirect('/admin/login');
    }

    public function test_admin_cannot_access_member_area(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web')
            ->get('/member/dashboard')
            ->assertRedirect('/member/login');
    }

    public function test_member_authenticated_does_not_authenticate_as_admin(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member');

        $this->assertAuthenticated('member');
        $this->assertGuest('web');
    }

    public function test_admin_authenticated_does_not_authenticate_as_member(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web');

        $this->assertAuthenticated('web');
        $this->assertGuest('member');
    }

    public function test_member_cannot_access_admin_books(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member')
            ->get('/admin/books')
            ->assertRedirect('/admin/login');
    }

    public function test_member_cannot_access_admin_members(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member')
            ->get('/admin/members')
            ->assertRedirect('/admin/login');
    }

    public function test_member_cannot_access_admin_borrowings(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member')
            ->get('/admin/borrowings')
            ->assertRedirect('/admin/login');
    }

    public function test_member_cannot_access_admin_returns(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($member, 'member')
            ->get('/admin/returns')
            ->assertRedirect('/admin/login');
    }

    public function test_admin_cannot_access_member_books(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web')
            ->get('/member/books')
            ->assertRedirect('/member/login');
    }

    public function test_admin_cannot_access_member_borrowings(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web')
            ->get('/member/borrowings')
            ->assertRedirect('/member/login');
    }

    public function test_admin_cannot_access_member_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web')
            ->get('/member/profile')
            ->assertRedirect('/member/login');
    }
}
