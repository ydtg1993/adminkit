<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2018/12/22
 * Time: 10:49
 */

namespace App\Http\Controllers;

class Home extends Controller
{
    public function index()
    {
        return view('home/index',self::$data);
    }
}