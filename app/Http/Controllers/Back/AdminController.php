<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('back.index');
    }
}
