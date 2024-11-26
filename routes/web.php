<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptocurrencyController;
use App\Http\Controllers\UpdateAllPricesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('cryptocurrency')->group(function () {
        Route::get('/', [CryptocurrencyController::class, 'index'])->name('cryptocurrency.index');
        Route::get('/create', [CryptocurrencyController::class, 'create'])->name('cryptocurrency.create');
        Route::post('/store', [CryptocurrencyController::class, 'store'])->name('cryptocurrency.store');
        Route::get('{id}/edit', [CryptocurrencyController::class, 'edit'])->name('cryptocurrency.edit');
        Route::put('update/{id}', [CryptocurrencyController::class, 'update'])->name('cryptocurrency.update');
        Route::delete('{id}', [CryptocurrencyController::class, 'destroy'])->name('cryptocurrency.destroy');

        Route::get('/update-all', [UpdateAllPricesController::class, 'updateAll'])->name('cryptocurrency.updateAll');
    });

});


require __DIR__.'/auth.php';



