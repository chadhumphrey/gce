<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;

use Tests\TestCase;

class RegistrationTest extends TestCase
{

    // use RefreshDatabase;
    /**
     * A basic feature test example.
     */
     public function test_can_register(){
       Livewire::test('register')
       ->set('email','chad@gmail.com')
       ->set('password','password')
       ->set('passwordConfirmation','password')
       ->call('register')
       ->assetRedirect('/');

       $this->assertTrue(User::whereEmail('chad@gmail.com')->exist());

       $this->assertEquals('chad@gmail.com', auth()->user()->email);

     }

     public function email_is_required(){
       Livewire::test('register')
       ->set('email','chad@gmail.com')
       ->set('password','password')
       ->set('passwordConfirmation','password')
       ->call('register')
       ->assertHasErrors(['email' => 'required']);
     }
}
