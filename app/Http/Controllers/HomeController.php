<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function home(){
        $data = [
            'title' => 'Login'
        ];

        return view('pages/home')->with($data);
    }
}