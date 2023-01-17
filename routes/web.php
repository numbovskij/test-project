<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name('user.')->group(function () {
    Route::get('/ticket', [TicketController::class, 'index'])->middleware('auth')->name('ticket');

    Route::post('/ticket-create', [TicketController::class, 'create'])->name('ticket-create');

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect(route('user.create.ticket'));
        }

        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/logout', function () {
        Auth::logout();

        redirect('/');
    });

    Route::get('/registration', function () {
        if (Auth::check()) {
            return redirect(route('user.ticket'));
        }

        return view('registration');
    })->name('registration');

    Route::post('/registration', [RegisterController::class, 'save']);
});
