<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancaController extends Controller
{
    public function financa_dashboard()
    {
        return view('departamentishitjes::financa.dashboard');
    }

    public function financa_projekti()
    {
        return view('departamentishitjes::financa.projekti');
    }
}
