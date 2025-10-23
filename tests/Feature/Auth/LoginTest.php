<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function login_page_can_be_rendered()
    {
        $this->get(route('login'))
            ->assertSuccessful();
    }

    #[Test]
    public function a_user_can_login()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password'),
        ]);

        Livewire::test('auth.login')
            ->set('username', 'testuser')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function a_user_cannot_login_with_incorrect_password()
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password'),
        ]);

        Livewire::test('auth.login')
            ->set('username', 'testuser')
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors(['username']);

        $this->assertGuest();
    }

    #[Test]
    public function username_is_required_for_login()
    {
        Livewire::test('auth.login')
            ->set('username', '')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors(['username' => 'required']);
    }

    #[Test]
    public function password_is_required_for_login()
    {
        Livewire::test('auth.login')
            ->set('username', 'testuser')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors(['password' => 'required']);
    }
}
