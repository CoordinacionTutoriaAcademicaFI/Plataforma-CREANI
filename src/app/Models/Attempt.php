<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attempt extends Model
{
    protected $fillable = [
        'alumno_id',
        'quiz_id',
        'inicio_at',
        'fin_at',
        'puntaje',
        'detalle_por_seccion_json',
    ];

    protected $casts = [
        'inicio_at'               => 'datetime',
        'fin_at'                  => 'datetime',
        'detalle_por_seccion_json'=> 'array',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
