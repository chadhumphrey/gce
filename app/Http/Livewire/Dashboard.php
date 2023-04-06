<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Spammers;

class Dashboard extends Component
{
    public $emails, $email,$total_emails,$barf;
    public $updateMode = false;



    public function render()
    {
        $this->emails =Spammers::orderBy('id', 'desc')->limit(10)->get();
        $this->total_emails =Spammers::orderBy('id', 'asc')->get()->count();

        return view('livewire.dashboard')
        ->section('content')
        ->extends('layouts.app');
    }


   public function show($id)
   {
       $this->email = Spammers::find($id);
       $this->updateMode = true;
   }

   public function cancel()
   {
     $this->updateMode = false;
     $this->email='';
   }

}
