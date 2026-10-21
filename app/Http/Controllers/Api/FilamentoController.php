<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilamentoResource;
use App\Models\Filamento;
use Illuminate\Http\Request;

class FilamentoController extends Controller
{
    public function index()
    {
        return FilamentoResource::collection(Filamento::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'material' => ['required', 'string', 'max:50'],
            'cor' => ['required', 'string', 'max:50'],
            'marca' => ['nullable', 'string', 'max:100'],
            'peso_gramas' => ['sometimes', 'integer', 'min:1'],
            'preco' => ['required', 'numeric', 'min:0'],
            'estoque' => ['sometimes', 'integer', 'min:0'],
        ]);

        $filamento = Filamento::create($dados);

        return (new FilamentoResource($filamento))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Filamento $filamento)
    {
        return new FilamentoResource($filamento);
    }

    public function update(Request $request, Filamento $filamento)
    {
        $dados = $request->validate([
            'material' => ['sometimes', 'string', 'max:50'],
            'cor' => ['sometimes', 'string', 'max:50'],
            'marca' => ['nullable', 'string', 'max:100'],
            'peso_gramas' => ['sometimes', 'integer', 'min:1'],
            'preco' => ['sometimes', 'numeric', 'min:0'],
            'estoque' => ['sometimes', 'integer', 'min:0'],
        ]);

        $filamento->update($dados);

        return new FilamentoResource($filamento);
    }

    public function destroy(Filamento $filamento)
    {
        $filamento->delete();

        return response()->noContent();
    }
}