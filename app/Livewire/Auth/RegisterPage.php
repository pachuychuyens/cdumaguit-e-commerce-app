<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

#[Title('Register')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    //register user

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6',
        ]);

        //save database

        $user = User::create([
            'name' => $this -> name,
            'email' => $this ->email,
            'password' => Hash::make($this->password),
        ]);

        //login user
        auth()->login($user);

        //redirect to homepage

        return redirect('/');


    }
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
