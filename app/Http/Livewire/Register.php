<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Register extends Component
{
    public $email ='';
    public $password ='';
    public $passwordConfirmation ='';

    public function register(){

      $data= $this->validate([
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6|same:passwordConfirmation'
      ]);

      $user = User::create([
        'email' => '',
        'password' => Hash::make()
      ]);

      auth()->login($user);


      return redirect('/');
    }

    public function render()
    {

      return view('livewire.register')

          ->extends('layouts.app')

          ->section('body');
        // return view('livewire.register');
    }
}
