<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class topmenu_controller extends Controller
{
    function index()
    {        
        return view('headquarters/topmenu/index');
    }

    function master_index()
    {        
        return view('master/index');
    }     
}
