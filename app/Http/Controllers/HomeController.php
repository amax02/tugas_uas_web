<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //

    public function index()
    {
        $data = array(
            'title' => 'Home Page'
        );

        if(Auth::check()){
            return view('home', $data);
        }

        return view('login', $data);

    }
}
