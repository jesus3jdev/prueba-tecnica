<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




//Agrupamos las rutas en las que el usuario necesita estar logueado
    Route::middleware('auth')->group(function () {
        
        //Indicamos que la raíz del proyecto vaya a la vista del tablero protegida por autenticación
        Route::get('/', function () {
            return view('tablero');
        })->name('tablero');


        //Agrupamos las rutas en las que el usuario necesita estar logueado y ser administrador (Middlware creado)
        Route::get('/auditoria', function () {
            return view('auditoria');
        })->name('auditoria')->middleware('admin');
        
    });



require __DIR__.'/auth.php';
