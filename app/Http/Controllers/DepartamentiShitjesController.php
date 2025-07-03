<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartamentiShitjesController extends Controller
{
    public function index()
    {
        return view('departamentishitjes::index');
    }
}
