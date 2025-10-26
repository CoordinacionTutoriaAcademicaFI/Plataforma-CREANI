<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntakeFormRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

   public function rules(): array
{
    $ingenierias = implode(',', array_keys(config('ingenierias.lista')));
    $convivenciasCat = [
        'Ambos padres','Ambos padres y hermanos','Únicamente con papá y hermanos',
        'Únicamente con mamá y hermanos','Únicamente con papá','Únicamente con mamá',
        'En una casa con varios conocidos','Solo (a) en un cuarto o casa',
    ];
    $plataformasCat = [
        'Microsoft Teams (TEAMS)','Schooology','Google Classroom','ALEKS',
        'Webassign','Khan Academy','Blackboard','McGraw Hill Connect',
    ];
    $mediosCat = [
        'ZOOM','Whatsapp','Correo electrónico','Facebook Messenger',
        'Google Meet','Webex','VooV Meeting','Microsoft Teams (TEAMS)','Schooology',
    ];
    $traslados = '<15,15-30,30-60,>60';


      $periodos = [];
    foreach (range(2026, 2030) as $y) { $periodos[]=$y.'A'; $periodos[]=$y.'B'; }
    $periodosStr = implode(',', $periodos);
    
    return [
        // * Requeridas
        'email_contacto'          => ['required','email','max:180'],         // Q1 *
        'ingenieria'              => ['required','in:'.$ingenierias],        // Q2 *
        'indice_uaem'             => ['required','numeric'],                 // Q4 *
        'lugar_examen'            => ['required','integer','min:1'],         // Q5 *
        'numero_folio'            => ['required','digits:9'],                // Q6 *
        'celular'                 => ['required','string','max:20'],         // Q9 *
        'internet_casa'           => ['required','boolean'],                 // Q10 *
        'equipo_computo'          => ['required','boolean'],                 // Q11 *
        'apellido_paterno'        => ['required','string','max:120'],        // Q14 *
        'apellido_materno'        => ['required','string','max:120'],        // Q15 *
        'nombres'                 => ['required','string','max:180'],        // Q16 *
        'periodo_ingreso' => ['required','in:'.$periodosStr],   // <— NUEVO select                // Q17 *
        'plataformas_usadas'      => ['required','array','min:1'],           // Q18 *
        'plataformas_usadas.*'    => ['string','in:'.implode(',', $plataformasCat)],
        'medios_comunicacion'     => ['required','array','min:1'],           // Q19 *
        'medios_comunicacion.*'   => ['string','in:'.implode(',', $mediosCat)],
        'email_contacto_confirm'  => ['required','email','max:180','same:email_contacto'], // Q20 *
        'vulnerabilidad_economica'=> ['required','boolean'],                 // Q23 *
        'condicion_medica'        => ['required','boolean'],                 // Q24 *

        // No marcadas con * (opcionales)
        'promedio_bachillerato'   => ['nullable','numeric','between:0,10'],  // Q3
        'numero_cuenta'           => ['nullable','digits:7'],                // Q7
        'facebook_url'            => ['nullable','url','max:2048'],          // Q8
        'convivencias'            => ['nullable','array'],                    // Q12 (múltiple)
        'convivencias.*'          => ['string','in:'.implode(',', $convivenciasCat)],
        'convivencia_otro'        => ['nullable','string','max:255'],
        'tiempo_traslado'         => ['nullable','in:'.$traslados],          // Q13
        'correo_institucional'    => ['nullable','boolean'],                  // Q21
        'uaem_email'              => ['nullable','email','max:180','required_if:correo_institucional,1'], // Q22 si marcó Sí
        'escuela_procedencia'      => ['nullable','string','max:255'],       // Q25
        'escuela_procedencia_otro' => ['nullable','string','max:255'],

        'plataformas_otro'        => ['nullable','string','max:255'],
        'medios_otro'             => ['nullable','string','max:255'],
        'extra'                   => ['nullable','array'],
    ];
}

public function messages(): array
{
    return [
        'email_contacto_confirm.same' => 'El segundo correo debe coincidir con el primero.',
        'plataformas_usadas.required' => 'Selecciona al menos una plataforma.',
        'medios_comunicacion.required'=> 'Selecciona al menos un medio.',
        'uaem_email.required_if'      => 'Escribe tu correo institucional si marcaste que sí tienes.',
        'periodo_ingreso.in'          => 'El periodo válido es 2024B.',
    ];
}

}
