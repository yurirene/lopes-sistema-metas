<?php

namespace App\Http\Controllers;

use App\DataTables\SupervisorDataTable;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index(SupervisorDataTable $dataTable)
    {
        return $dataTable->render('supervisor.index');
    }
}
