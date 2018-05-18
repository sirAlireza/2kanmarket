<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pubpagesController extends Controller
{
    public function about()
    {
        return view('footer/about');
    }
    public function faq()
    {
        return view('footer/faq');
    }
    public function callus()
    {
        return view('footer/callus');
    }
}
