<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ModuloController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ParticipanteController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('', [HomeController::class, 'index'])->middleware('can:admin.home')->name('admin.home');


Route::resource('modulos', ModuloController::class)->names('admin.modulos');

Route::get('modulos/{modulo}/participantes', [ParticipanteController::class,'show'])->name('admin.modulos.participantes.show');
Route::get('modulos/{modulo}/participantes/create', [ParticipanteController::class, 'create'])->name('admin.modulos.participantes.create');
Route::post('modulos/{modulo}/participantes', [ParticipanteController::class,'store'])->name('admin.modulos.participantes.store');
Route::delete('modulos/{modulo}/participantes', [ParticipanteController::class,'destroy'])->name('admin.modulos.participantes.destroy');

Route::resource('users', UserController::class)->names('admin.users');
Route::resource('categories', CategoryController::class)->names('admin.categories');
