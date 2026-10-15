<?php

namespace Tests\Feature\Members;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_see_members_list(): void
    {
        $this->actingAs($this->admin, 'web')
            ->get('/admin/members')
            ->assertStatus(200);
    }

    public function test_admin_can_create_member(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('member_code', 'LIB-000123')
            ->set('name', 'Budi Santoso')
            ->set('email', 'budi@mail.com')
            ->set('password', 'password')
            ->set('phone', '08123456789')
            ->set('address', 'Jakarta')
            ->set('status', 'active')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('members', [
            'member_code' => 'LIB-000123',
            'name' => 'Budi Santoso',
            'email' => 'budi@mail.com',
            'status' => 'active',
        ]);
    }

    public function test_member_code_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('member_code', '')
            ->call('save')
            ->assertHasErrors('member_code');
    }

    public function test_member_name_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('name', '')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_member_email_is_required(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('email', '')
            ->call('save')
            ->assertHasErrors('email');
    }

    public function test_member_password_is_required_on_create(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('password', '')
            ->call('save')
            ->assertHasErrors('password');
    }

    public function test_member_code_must_be_unique(): void
    {
        Member::factory()->create(['member_code' => 'LIB-000123']);

        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('member_code', 'LIB-000123')
            ->set('name', 'Test')
            ->set('email', 'test@mail.com')
            ->set('password', 'password')
            ->call('save')
            ->assertHasErrors('member_code');
    }

    public function test_member_email_must_be_unique(): void
    {
        Member::factory()->create(['email' => 'budi@mail.com']);

        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('member_code', 'LIB-000124')
            ->set('name', 'Test')
            ->set('email', 'budi@mail.com')
            ->set('password', 'password')
            ->call('save')
            ->assertHasErrors('email');
    }

    public function test_admin_can_edit_member(): void
    {
        $member = Member::factory()->create(['name' => 'Old Name']);

        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->call('edit', $member->id)
            ->set('name', 'New Name')
            ->call('save')
            ->assertHasNoErrors();

        $member->refresh();

        $this->assertSame('New Name', $member->name);
    }

    public function test_admin_can_delete_member(): void
    {
        $member = Member::factory()->create();

        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->call('delete', $member->id);

        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    public function test_admin_can_search_members(): void
    {
        Member::factory()->create(['name' => 'Budi Santoso']);
        Member::factory()->create(['name' => 'Siti Aminah']);

        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('search', 'Budi')
            ->assertSee('Budi Santoso')
            ->assertDontSee('Siti Aminah');
    }

    public function test_admin_can_filter_members_by_status(): void
    {
        Member::factory()->create(['name' => 'Active Member', 'status' => 'active']);
        Member::factory()->create(['name' => 'Inactive Member', 'status' => 'inactive']);

        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('filterStatus', 'inactive')
            ->assertSee('Inactive Member')
            ->assertDontSee('Active Member');
    }

    public function test_password_is_hashed_on_create(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('member_code', 'LIB-000123')
            ->set('name', 'Budi')
            ->set('email', 'budi@mail.com')
            ->set('password', 'password')
            ->set('status', 'active')
            ->call('save');

        $member = Member::where('member_code', 'LIB-000123')->first();

        $this->assertNotSame('password', $member->password);
        $this->assertTrue(password_verify('password', $member->password));
    }

    public function test_can_generate_member_code(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->call('generateCode')
            ->assertHasNoErrors();

        // The generated code should start with LIB- and be non-empty
        $component = Livewire::actingAs($this->admin, 'web')->test('member.manager');
        $component->call('generateCode');

        $this->assertNotEmpty($component->get('member_code'));
        $this->assertMatchesRegularExpression('/^(LIB-|M)/', $component->get('member_code'));
    }

    public function test_created_member_can_login(): void
    {
        Livewire::actingAs($this->admin, 'web')
            ->test('member.manager')
            ->set('member_code', 'LIB-000123')
            ->set('name', 'Budi')
            ->set('email', 'budi@mail.com')
            ->set('password', 'password')
            ->set('status', 'active')
            ->set('active_until', now()->addYear()->format('Y-m-d'))
            ->call('save');

        $member = Member::where('member_code', 'LIB-000123')->first();

        $this->assertNotNull($member);
        $this->assertTrue(password_verify('password', $member->password));
        $this->assertSame('active', $member->status);
    }
}
