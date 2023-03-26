<?php

namespace App\Services;

use App\Models\User;
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

    public static function delete($usuario) : void
    {
        try {
            $usuario = User::find($usuario);
            $usuario->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
