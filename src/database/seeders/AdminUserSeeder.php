<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'tutoria_fi@uaemex.mx'],
            [
                'name' => 'Tutoría FI',
                'password' => Hash::make('Tu70ri4a99'),
                'rol' => 'admin',
                'email_verified_at' => now(), // por si usas "verified" en otras rutas
            ]
        );
    }
    // ruta del admin: http://localhost:8080/admin/login
}
