<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Agrupamos las rutas por controladores 

//Indicamos que la raíz del proyecto vaya a la vista del tablero protegida por autenticación
Route::get('/', function () {
    return view('tablero');
})->middleware(['auth', 'verified'])->name('tablero');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
