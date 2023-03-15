<?php

namespace App\Http\Controllers;

use App\DataTables\VendedorDataTable;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function index(VendedorDataTable $dataTable)
    {
        return $dataTable->render('vendedor.index');
    }
}
