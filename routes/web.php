<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Home as Dashboard;
use App\Livewire\Dashboard\Deposit;
use App\Livewire\Dashboard\Withdraw;
use App\Livewire\Home;

Route::get('/', Home::class)->name('home');

Route::middleware('guest')->group(function () {
  Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', Dashboard::class)->name('dashboard');
  Route::get('/deposit', Deposit::class)->name('deposit');
  Route::get('/withdraw', Withdraw::class)->name('withdraw');
  Route::get('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
  })->name('logout');
});
