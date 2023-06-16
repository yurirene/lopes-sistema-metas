<?php

namespace App\Services;

use App\Models\Perfil;

class PerfilService
{
    public static function store(string $nome) : ?Perfil
    {
        try {
            return Perfil::create([
                'nome' => $nome,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function update(string $nome, Perfil $perfil) : ?Perfil
    {
        try {
            $perfil->update([
                'nome' => $nome
            ]);
            return $perfil;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getToSelect() : array
    {
        try {
            return Perfil::where('name', '<>' ,'supervisor')
                ->get()
                ->pluck('nome', 'id')
                ->toArray();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
