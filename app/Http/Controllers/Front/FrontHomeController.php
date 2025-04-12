<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class FrontHomeController extends Controller
{
    public function index()
    {
        return view('front.login');
    }
}
