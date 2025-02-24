<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Common\ExternalApisController;
use App\Http\Controllers\UserController;

Route::get('/', fn() => auth()->check() ? redirect()->route('contact.show.all') : view('auth.login'))->name('home');

// ROTAS DE AUTENTICAÇÃO (Apenas para usuários não autenticados)
Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login.view');

    Route::get('recover/{email}/{token}', [AuthController::class, 'showRecoverPassword'])->name('recover-password.view');
    Route::get('email/validate/{id}/{token}', [AuthController::class, 'validateEmail'])->name('validate-email');

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('forget-password', [AuthController::class, 'sendPasswordResetLink'])->name('forget-password');
    Route::post('recover-password', [AuthController::class, 'resetPassword'])->name('recover-password');
});

// ROTAS PROTEGIDAS POR AUTENTICAÇÃO
Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // CONTATOS
    Route::view('contacts', 'contacts.index')->name('contact.show.all');
    Route::resource('contact', ContactController::class);

    // USUÁRIOS
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.show');
        Route::put('/', [UserController::class, 'update'])->name('user.update');
        Route::delete('/', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // API EXTERNA (CEP, ENDEREÇO)
    Route::prefix('api')->group(function () {
        Route::get('cep/{cep}', [ExternalApisController::class, 'cep'])->name('cep');
        Route::get('address', [ExternalApisController::class, 'address'])->name('address');
    });
});
