<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            User::updateOrCreate([
                'name' => 'Yuri',
                'email' => 'yurirene@gmail.com',
                'password' => Hash::make('123'),
                'is_admin' => true,
                'perfil_id' => 1
            ]);
            User::updateOrCreate([
                'name' => 'Supervisor',
                'email' => 'supervisor@email.com',
                'password' => Hash::make('123'),
                'is_admin' => true,
                'perfil_id' => 3
            ]);
            User::updateOrCreate([
                'name' => 'Gerente',
                'email' => 'gerente@email.com',
                'password' => Hash::make('123'),
                'is_admin' => true,
                'perfil_id' => 2
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
