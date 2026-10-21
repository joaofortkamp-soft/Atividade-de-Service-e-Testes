<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filamento extends Model
{
    protected $fillable = [
        'material',
        'cor',
        'marca',
        'peso_gramas',
        'preco',
        'estoque',
    ];
}