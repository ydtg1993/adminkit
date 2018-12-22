<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2018/12/22
 * Time: 10:49
 */

namespace App\Http\Controllers;


use App\Http\Dao\UserActive;
use Illuminate\Support\Facades\Redirect;

class Home extends Controller
{
    public function index()
    {
        $flag = UserActive::check($user_info);
        if(!UserActive::check($flag)){
            return Redirect::to('/login');
        }
        Controller::$data['user_info'] = $user_info;
        return view('home/index',self::$data);
    }
}