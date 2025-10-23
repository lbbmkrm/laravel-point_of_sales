<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class RegisterForm extends Form
{
    public string $name = '';
    public string $username = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Get the validation rules.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}