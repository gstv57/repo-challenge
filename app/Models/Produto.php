<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'quantidade_em_estoque',
        'categoria',
        'brand',
        'modelo',
    ];
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
