<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController
{
    public function index(){
        return view('welcome');
    }
}
