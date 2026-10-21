<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilamentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'material' => $this->material,
            'cor' => $this->cor,
            'marca' => $this->marca,
            'peso_gramas' => $this->peso_gramas,
            'preco' => (float) $this->preco,
            'preco_por_kg' => round($this->preco / $this->peso_gramas * 1000, 2),
            'estoque' => $this->estoque,
            'disponivel' => $this->estoque > 0,
            'criado_em' => $this->created_at?->format('d/m/Y H:i'),
        ];
    }
}