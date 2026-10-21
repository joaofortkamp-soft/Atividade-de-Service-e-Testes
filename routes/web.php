<?php

use App\Http\Controllers\CotacaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cotacao', [CotacaoController::class, 'index']);