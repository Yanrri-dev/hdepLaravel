<?php

use App\Http\Controllers\CriterioController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ObtieneController;

Route::middleware(['auth:sanctum', 'verified'])->get('/', [ModuloController::class, 'index'])->name('modulos.index');

Route::middleware(['auth:sanctum', 'verified'])->get('/modulos/{modulo}', [ModuloController::class, 'show'])->name('modulos.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->resource('/modulos/{modulo}/evaluations', EvaluationController::class)->names('evaluations');

Route::middleware(['auth:sanctum', 'verified'])->resource('/modulos/{modulo}/evaluations/{evaluation}/preguntas', QuestionController::class)->names('preguntas');

Route::middleware(['auth:sanctum', 'verified'])->resource('/modulos/{modulo}/evaluations/{evaluation}/preguntas/{pregunta}/criterios', CriterioController::class)->names('criterios');

Route::middleware(['auth:sanctum', 'verified'])->put('/modulos/{modulo}/evaluations/{evaluation}/obtiene', [ObtieneController::class,'update'])->name('evaluation.obtiene');