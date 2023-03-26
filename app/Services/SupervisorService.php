<?php

namespace App\Services;

use App\Models\Perfil;
use App\Models\Permissao;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupervisorService
{

    /**
     * Método para atualizar o supervisor, usuário vinculado e permissões
     *
     * @param Supervisor $supervisor
     * @param array $request
     * @return void
     */
    public static function update(Supervisor $supervisor, array $request): void
    {
        DB::beginTransaction();
        try {
            $supervisor->update([
                'nome' => $request['nome'],
                'codigo' => $request['codigo']
            ]);
            if (!is_null($supervisor->usuario)) {
                $usuario = $supervisor->usuario;
                $usuario->update([
                    'email' => $request['email']
                ]);
                if (!empty($request['senha'])) {
                    $usuario->update([
                        'password' => Hash::make($request['senha'])
                    ]);
                }
            } else {

                $usuario = User::create([
                    'name' => $request['nome'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['senha'])
                ]);
                $supervisor->update([
                    'user_id' => $usuario->id
                ]);
            }
            $usuario->permissao()->sync($request['permissoes']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Método para cadastrar o supervisor, usuário vinculado e permissões
     *
     * @param Supervisor $supervisor
     * @param array $request
     * @return void
     */
    public static function store(array $request): void
    {
        DB::beginTransaction();
        try {
            $supervisor = Supervisor::create([
                'nome' => $request['nome'],
                'codigo' => $request['codigo']
            ]);

            $usuario = User::create([
                'name' => $request['nome'],
                'email' => $request['email'],
                'password' => Hash::make($request['senha']),
                'perfil_id' => Perfil::where('name', 'supervisor')->first()->id
            ]);

            $supervisor->update([
                'user_id' => $usuario->id
            ]);

            $usuario->permissao()->sync($request['permissoes'] ?? []);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
