<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulateDeposit;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('verify_bearer_token')->post('/simulate-deposit', [SimulateDeposit::class, 'deposit']);
