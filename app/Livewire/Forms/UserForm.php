<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rules;
use Livewire\Form;

class UserForm extends Form
{
    //
    public $user;
    #[Validate()]
    public $name;

    #[Validate()]
    public $email;

    #[Validate()]
    public $password;
    
    #[Validate()]
    public $password_confirmation;

    public function rules()
    {
        return [
            'name'      => ['required','max:255',Rule::unique('users','name')->ignore($this->user?->id)],
            'email'     => ['required','email',Rule::unique('users','email')->ignore($this->user?->id)],
            'password'  => [is_null($this->user) ? 'required' : 'nullable','min:8','max:255','confirmed', Rules\Password::defaults()]
        ];
    }

    public function store(){
        $this->validate();

        return User::create([
            ...$this->only('name','email'),
            'password'  => Hash::make($this->password),
            'exercise'  => now()->year,
        ]);
    }

    public function setUser($user){
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function update(){
        $this->validate();
        return $this->user->update([
            ...$this->only('name','email'),
            'password'  => is_null($this->password) ? $this->user->password : Hash::make($this->password)
        ]);
    }
}
