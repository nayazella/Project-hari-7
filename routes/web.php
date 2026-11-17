<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KatalogController;

Route::get('/', function () {
    return view('index');
});

Route::get('/sapa', function () {
    return 'Halo Saya Inayah';
});

Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

Route::post('/katalog', [KatalogController::class, 'store'])->name('katalog.store');

Route::get('/katalog/{id}', [KatalogController::class, 'show'])
    ->whereNumber('id')
    ->name('katalog.show');

Route::delete('/katalog/{id}', [KatalogController::class, 'destroy'])
    ->whereNumber('id')
    ->name('katalog.destroy');
