<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30 0030
 * Time: 下午 2:45
 */

namespace App\Http\Dao;

use App\Http\Model\UserModel;
use Carbon\Carbon;

class UserActive
{
    /**
     * @param $user_info
     * @return bool
     * @throws \Exception
     */
    public static function restore($user_info)
    {
        UserModel::upInfoWhere(['last_login_time'=>Carbon::today()->toDateString()]);
        return session(['administrator'=>json_encode($user_info)]);
    }

    /**
     * @param $user_info
     * @return bool
     * @throws \Exception
     */
    public static function check(&$user_info)
    {
        $user_info = session()->get('administrator');
        $user_info = (array)json_decode($user_info);
        if(!empty($user_info)){
            return true;
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public static function destroy()
    {
        session()->forget('administrator');
    }
}