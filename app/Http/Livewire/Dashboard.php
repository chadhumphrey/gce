<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Spammers;

class Dashboard extends Component
{
    public $users, $total_emails;
    public function render()
    {
      $this->total_emails = 10;
        $this->users =Spammers::orderBy('id', 'asc')->limit(10)->get();
        return view('livewire.dashboard');
    }
}
