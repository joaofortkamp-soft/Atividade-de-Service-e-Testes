<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CotacaoController extends Controller
{
    private string $url = 'https://economia.awesomeapi.com.br/json/last/';

    private function buscar(string $moedas): ?array
    {
        try {
            $resposta = Http::timeout(10)->get($this->url . $moedas);
        } catch (ConnectionException $e) {
            return null;
        }

        if ($resposta->failed()) {
            return null;
        }

        return collect($resposta->json())->map(fn ($c) => [
            'moeda' => $c['code'],
            'nome' => $c['name'],
            'compra' => (float) $c['bid'],
            'venda' => (float) $c['ask'],
            'variacao' => (float) $c['pctChange'],
            'atualizado_em' => $c['create_date'],
        ])->values()->all();
    }

    public function api(string $moeda = 'USD')
    {
        $dados = $this->buscar(strtoupper($moeda) . '-BRL');

        if ($dados === null) {
            return response()->json(['erro' => 'Moeda não encontrada ou API indisponível'], 404);
        }

        return response()->json(['data' => $dados[0]]);
    }

    public function index()
    {
        $cotacoes = $this->buscar('USD-BRL,EUR-BRL,BTC-BRL') ?? [];

        return view('cotacao', ['cotacoes' => $cotacoes]);
    }
}