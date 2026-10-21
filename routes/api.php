<?php

use App\Http\Controllers\Api\FilamentoController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\CotacaoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/produtos', ProdutoController::class);

Route::apiResource('/filamentos', FilamentoController::class);

Route::get('/cotacao/{moeda?}', [CotacaoController::class, 'api']);