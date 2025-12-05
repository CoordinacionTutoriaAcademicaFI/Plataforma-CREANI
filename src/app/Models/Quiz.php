<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;   // 👈 importa el trait

class Quiz extends Model
{
    use SoftDeletes;   // 👈 activa SoftDeletes en este modelo

    protected $fillable = [
        'titulo',
        'descripcion',
        'area',
        'tema',
        'inicio_at',
        'cierre_at',
        'estado',
        'created_by',
    ];

    protected $casts = [
        'inicio_at' => 'datetime',
        'cierre_at' => 'datetime',
    ];

    // 1) Relación con sections
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    // 2) Relación con attempts
    public function attempts(): HasMany
    {
        return $this->hasMany(\App\Models\Attempt::class);
    }
}
