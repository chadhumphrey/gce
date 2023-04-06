<?php

// use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//
// Route::get('/', function () {
//     return view('dashboard');
// });
// Route::get('/edit/{$id}', 'livewire.dashboard.edit');



Route::view('/','dashboard');
// Route::view('/email/{id}',  'livewire.show');
// Route::get('/email/{id}', \App\Http\Livewire\Dashboard::class,'show');


// Route::view('/register', 'livewire.register');
// Route::get('/login', function(){
//   return view('login');
// });

// Route::view('login','livewire.login-register')->name('login');
// Route::get('/login',Login::class);

// Route::get('/', ['App\Http\Livewire\class::home'])->name('home')->middleware('auth');
// Route::group(['middleware'=>'guest'], function () {
    // Route::view('login','livewire.login');

    // Route::get('/register',    App\Http\Livewire\Register::render);

    // Route::get('register', 'livewire.register');
// });
// Route::post('/login',  [App\Http\Controllers\API\AuthController::class,'login'])->name('login');

// Route::get('/register', function(){
//   return view('register');
// });

// Route::get('/dashboard', function(){
//   return view('dashboard');
// })->middleware('auth');
