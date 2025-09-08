<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'teste@email.com'],
            [
                'name' => 'Usuário Teste',
                'password' => Hash::make('123'), 
            ]
        );
    }
}
