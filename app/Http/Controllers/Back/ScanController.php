<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    public function index()
    {
        return view('back.scan.index');
    }
}
