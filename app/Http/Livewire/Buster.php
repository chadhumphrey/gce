<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Buster extends Component
{
    public $dog = 'Benny';
    public $email ='Chico';
    public $password ='';
    public $passwordConfirmation ='';
    public $stuff = 'meh';

    public function mount()
    {
        $this->dog = 'Benny';
        $this->stuff = 'stuff content';
    }

    public function render()
    {
        return view('livewire.buster');
    }
}
