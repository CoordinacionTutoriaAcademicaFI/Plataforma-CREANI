<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'section_id',
        'enunciado_html',
        'latex',
        'imagen_url',
        'image_path',       // imagen principal de la pregunta
        'option_a_image',   // imagen de la opción A
        'option_b_image',   // imagen de la opción B
        'option_c_image',   // imagen de la opción C
        'option_d_image',   // imagen de la opción D
        'opciones_json',
        'correcta_idx',
        'dificultad',
        'tags_json',
    ];

    protected $casts = [
        'opciones_json' => 'array',
        'tags_json'     => 'array',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
