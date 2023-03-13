<?php

namespace App\Services;

use App\Imports\PlanilhaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PlanilhaService
{


    public static function importar(Request $request) : void
    {
        try {
            Excel::import(new PlanilhaImport(), $request->file('planilha'));
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
