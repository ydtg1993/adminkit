<?php

namespace App\Http\Controllers;

use App\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function list()
    {
        $managers = Manager::paginate(1);
        return view('managers.list',compact('managers'));
    }
}
