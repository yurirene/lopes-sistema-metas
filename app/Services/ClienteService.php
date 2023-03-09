<?php 

namespace App\Services;

use App\Models\Cliente;
use App\Models\Perfil;
use Illuminate\Support\Facades\Hash;

class ClienteService
{
    public static function store(array $request) : ?Cliente
    {
        try {
            $cliente = Cliente::create([
                'nome' => $request['nome'],
                'cpf' => $request['cpf'],
                'codigo_qr' => Hash::make($request['nome'].$request['cpf'])
            ]);
            $cliente->usuario()->create([
                'name' => $request['nome'],
                'email' => $request['email'],
                'password' => Hash::make('123'),
                'perfil_id' => Perfil::where('name', 'clientes')->get()->first()->id
            ]);
            return $cliente;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function update(array $request, Cliente $cliente) : ?Cliente
    {
        try {
            
            $cliente->update([
                'nome' => $request['nome'],
                'cpf' => $request['cpf'],
                'codigo_qr' => Hash::make($request['nome'].$request['cpf'])
            ]);
            $cliente->usuario()->update([
                'name' => $request['nome'],
                'email' => $request['email'],
            ]);

            return $cliente;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    

}
