<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntakeFormRequest;
use App\Models\IntakeForm;
use Illuminate\Http\Request;

class IntakeFormController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        $form = IntakeForm::firstOrNew(
            ['user_id' => $user->id],
            ['email_contacto' => $user->email, 'ingenieria' => $user->ingenieria]
        );

        $plataformas = [
            'Microsoft Teams (TEAMS)','Schooology','Google Classroom','ALEKS',
            'Webassign','Khan Academy','Blackboard','McGraw Hill Connect',
        ];
        $medios = [
            'ZOOM','Whatsapp','Correo electrónico','Facebook Messenger',
            'Google Meet','Webex','VooV Meeting','Microsoft Teams (TEAMS)','Schooology',
        ];
        $traslados = [
            '<15'=>'Menos de 15 minutos','15-30'=>'15 a 30 minutos',
            '30-60'=>'30 a 60 minutos','>60'=>'Más de 60 minutos'
        ];
        $convivencias = [
            'Ambos padres','Ambos padres y hermanos','Únicamente con papá y hermanos',
            'Únicamente con mamá y hermanos','Únicamente con papá','Únicamente con mamá',
            'En una casa con varios conocidos','Solo (a) en un cuarto o casa',
        ];

        $escuelas = config('escuelas.lista');

         $periodos = [];
    foreach (range(2026, 2030) as $y) {
        $periodos[] = $y.'A';
        $periodos[] = $y.'B';
    }

        return view('intake.create', compact(
            'form','plataformas','medios','traslados','convivencias','escuelas','periodos'
        ));
    }

    public function store(IntakeFormRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        foreach (['internet_casa','equipo_computo','correo_institucional','vulnerabilidad_economica','condicion_medica'] as $b) {
            $data[$b] = (bool) ($data[$b] ?? false);
        }
        $data['plataformas_usadas']  = $data['plataformas_usadas']  ?? [];
        $data['medios_comunicacion'] = $data['medios_comunicacion'] ?? [];
        $data['convivencias']        = $data['convivencias']        ?? [];
        $data['submitted_at']        = now();

        // Snapshot exacto Q1–Q25
        $data['answers_json'] = [
            'Q1_correo'                           => $data['email_contacto'] ?? null,
            'Q2_ingenieria'                       => $data['ingenieria'] ?? null,
            'Q3_promedio_bachillerato'            => $data['promedio_bachillerato'] ?? null,
            'Q4_indice_uaem'                      => $data['indice_uaem'] ?? null,
            'Q5_lugar_examen'                     => $data['lugar_examen'] ?? null,
            'Q6_numero_folio'                     => $data['numero_folio'] ?? null,
            'Q7_numero_cuenta'                    => $data['numero_cuenta'] ?? null,
            'Q8_facebook_url'                     => $data['facebook_url'] ?? null,
            'Q9_celular'                          => $data['celular'] ?? null,
            'Q10_internet_casa'                   => $data['internet_casa'],
            'Q11_equipo_computo'                  => $data['equipo_computo'],
            'Q12_convivencias'                    => $data['convivencias'],
            'Q12_convivencia_otro'                => $data['convivencia_otro'] ?? null,
            'Q13_tiempo_traslado'                 => $data['tiempo_traslado'] ?? null,
            'Q14_apellido_paterno'                => $data['apellido_paterno'] ?? null,
            'Q15_apellido_materno'                => $data['apellido_materno'] ?? null,
            'Q16_nombres'                         => $data['nombres'] ?? null,
            'Q17_periodo_ingreso'                 => $data['periodo_ingreso'] ?? null,
            'Q18_plataformas_usadas'              => $data['plataformas_usadas'],
            'Q18_plataformas_otro'                => $data['plataformas_otro'] ?? null,
            'Q19_medios_comunicacion'             => $data['medios_comunicacion'],
            'Q19_medios_otro'                     => $data['medios_otro'] ?? null,
            'Q20_correo_confirmacion'             => $data['email_contacto_confirm'] ?? null,
            'Q21_tiene_correo_institucional'      => $data['correo_institucional'],
            'Q22_uaem_email'                      => $data['uaem_email'] ?? null,
            'Q23_vulnerabilidad_economica'        => $data['vulnerabilidad_economica'],
            'Q24_condicion_medica'                => $data['condicion_medica'],
            'Q25_escuela_procedencia'             => $data['escuela_procedencia'] ?? null,
            'Q25_escuela_procedencia_otro'        => $data['escuela_procedencia_otro'] ?? null,
        ];

        IntakeForm::updateOrCreate(['user_id' => $data['user_id']], $data);

        return redirect()->route('dashboard')->with('status','form-ok');
    }
}
