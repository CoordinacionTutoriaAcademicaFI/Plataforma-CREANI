<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeForm extends Model
{
    protected $fillable = [
    'user_id','email_contacto','email_contacto_confirm','ingenieria',
    'promedio_bachillerato','indice_uaem','lugar_examen','numero_folio','numero_cuenta',
    'facebook_url','celular','internet_casa','equipo_computo',
    'convivencias','convivencia_otro','tiempo_traslado',
    'apellido_paterno','apellido_materno','nombres','periodo_ingreso',
    'plataformas_usadas','plataformas_otro','medios_comunicacion','medios_otro',
    'correo_institucional','uaem_email',
    'vulnerabilidad_economica','condicion_medica',
    'escuela_procedencia','escuela_procedencia_otro',
    'extra','answers_json','submitted_at',
];

protected $casts = [
    'promedio_bachillerato'    => 'decimal:2',
    'indice_uaem'              => 'decimal:3',
    'internet_casa'            => 'boolean',
    'equipo_computo'           => 'boolean',
    'plataformas_usadas'       => 'array',
    'medios_comunicacion'      => 'array',
    'convivencias'             => 'array',
    'correo_institucional'     => 'boolean',
    'vulnerabilidad_economica' => 'boolean',
    'condicion_medica'         => 'boolean',
    'answers_json'             => 'array',
    'submitted_at'             => 'datetime',
];

    public function user(){ return $this->belongsTo(User::class); }
}
