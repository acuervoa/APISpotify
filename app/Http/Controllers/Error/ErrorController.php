<?php

namespace App\Http\Controllers\Error;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{

    public static function errorHandler()
    {
        return view('error.errorPage');
    }
}
