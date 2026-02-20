<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeAwal extends Controller
{
    public function index()
    {
        return view('customer.home');
    }
}
