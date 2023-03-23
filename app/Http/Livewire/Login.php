<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $form = [
        'email'   => '',
        'password'=> '',
    ];

    public function login()
    {
      $x="hello"; dd(__LINE__,__METHOD__, $x);
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! auth()->attempt($credentials)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }


        return redirect('/barf');
        // return redirect()->intended('/barf');
      }

    public function render()
    {
      echo "28";
        return view('login');
    }
}
