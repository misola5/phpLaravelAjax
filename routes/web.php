<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

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
});

Route::controller(CursoController::class)->group(function(){
    Route::get('curso-index','index')->name('curso.index');
    Route::post('lista-cursos', 'listar_cursos')->name('curso.lista');
    Route::post('registro-curso', 'registrar_curso')->name('curso.registrar');
    Route::post('obtener-curso', 'obtener_curso')->name('curso.obtener_curso');
    //chatGPT
    Route::delete('eliminar-curso', 'eliminar_curso')->name('curso.eliminar');
});

require __DIR__.'/auth.php';
