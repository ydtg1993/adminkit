<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function list()
    {
        $roles = Role::paginate(1);
        return view('roles.list', compact('roles'));
    }
}
