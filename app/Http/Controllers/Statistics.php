<?php

namespace App\Http\Controllers;

class Statistics extends Admin
{
    public function index()
    {
        return view('statistics.index',self::$data);
    }

    public function console()
    {
        return view('statistics.console',compact('data'));
    }
}
