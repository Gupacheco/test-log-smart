<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('home');

Route::prefix('usuarios')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/users', [UserController::class, 'users'])->name('users.users');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/sortear-amigo', [UserController::class, 'sortearAmigo'])->name('drawFriend');
