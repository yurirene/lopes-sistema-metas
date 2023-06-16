<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{

    public static function getUsers() : Collection
    {
        try {
            return User::all();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getUsersToSelect() : array
    {
        try {
            return User::all()->pluck('name', 'id')->toArray();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function store(array $request) : ?User
    {
        try {
            return User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'perfil_id' => $request['perfil_id']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function update(array $request, User $usuario) : ?User
    {
        try {
            $usuario->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'perfil_id' => $request['perfil_id']
            ]);
            if (!empty($request['password'])) {
                $usuario->update(['password' => Hash::make($request['password'])]);
            }
            return $usuario;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function status(User $usuario): void
    {
        try {
            $usuario->update([
                'status' => !$usuario->status
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function atualizarSenha(User $usuario, array $request): void
    {
        try {
            if (!Hash::check($request['senhaAntiga'], $usuario->password)) {
                throw new Exception("Senha Incorreta", 1);
            }
            $usuario->update([
                'password' => Hash::make($request['novaSenha']),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
