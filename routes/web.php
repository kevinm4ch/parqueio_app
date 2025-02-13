<?php

use App\Http\Controllers\PatioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [PatioController::class, 'getPatios'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/patio/{patio_id}', [PatioController::class, 'getPatio'])->middleware(['auth', 'verified'])->name('patio');


Route::post('/patio/{patio_id}', [PatioController::class, 'gerarTicket'])->middleware(['auth', 'verified'])->name('gerar');



require __DIR__.'/auth.php';
