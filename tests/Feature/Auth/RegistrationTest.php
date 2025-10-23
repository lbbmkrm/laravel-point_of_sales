<?php

namespace Tests\Feature\Auth;

use App\Livewire\Forms\RegisterForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function registration_page_can_be_rendered()
    {
        $this->get(route('register'))
            ->assertSuccessful();
    }

    #[Test]
    public function a_user_can_register()
    {
        Livewire::test('auth.register')
            ->set('form.name', 'Test User')
            ->set('form.username', 'testuser')
            ->set('form.phone', '081234567890')
            ->set('form.password', 'password')
            ->set('form.password_confirmation', 'password')
            ->call('register')
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
        ]);

        $this->assertAuthenticated();
    }

    #[Test]
    public function username_is_required()
    {
        Livewire::test('auth.register')
            ->set('form.name', 'Test User')
            ->set('form.username', '')
            ->set('form.password', 'password')
            ->set('form.password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors(['form.username' => 'required']);
    }

    #[Test]
    public function username_must_be_unique()
    {
        \App\Models\User::factory()->create(['username' => 'testuser']);

        Livewire::test('auth.register')
            ->set('form.name', 'Test User')
            ->set('form.username', 'testuser')
            ->set('form.password', 'password')
            ->set('form.password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors(['form.username' => 'unique']);
    }

    #[Test]
    public function password_is_required()
    {
        Livewire::test('auth.register')
            ->set('form.name', 'Test User')
            ->set('form.username', 'testuser')
            ->set('form.password', '')
            ->set('form.password_confirmation', '')
            ->call('register')
            ->assertHasErrors(['form.password' => 'required']);
    }

    #[Test]
    public function password_must_be_confirmed()
    {
        Livewire::test('auth.register')
            ->set('form.name', 'Test User')
            ->set('form.username', 'testuser')
            ->set('form.password', 'password')
            ->set('form.password_confirmation', 'not-password')
            ->call('register')
            ->assertHasErrors(['form.password' => 'confirmed']);
    }
}
