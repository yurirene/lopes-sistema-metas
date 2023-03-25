<?php

namespace App\Http\Controllers;

use App\DataTables\SupervisorDataTable;
use App\DataTables\VendedorDataTable;
use App\Models\Log;
use App\Models\Supervisor;
use App\Services\PermissaoService;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index(SupervisorDataTable $dataTable)
    {
        return $dataTable->render('supervisor.index');
    }

    public function show(Supervisor $supervisor)
    {
        $dataTable = new VendedorDataTable($supervisor);
        return $dataTable->render('supervisor.show', [
            'supervisor' => $supervisor
        ]);
    }

    public function create()
    {
        return view('supervisor.form', [
            'permissoes' => PermissaoService::listarPermissoes()
        ]);
    }

    public function edit(Supervisor $supervisor)
    {
        return view('supervisor.form', [
            'supervisor' => $supervisor
        ]);
    }
}
