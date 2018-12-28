<?php

namespace App\Http\Controllers;

use App\Http\Src\Postfix;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $expression = "a+b*(c^d-e)^(f+g*h)-i";

        $postfix = new Postfix();

        return $postfix->convert($expression);
    }
}
