<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30 0030
 * Time: 下午 2:45
 */

namespace App\Http\Dao;


use App\Http\Common\RedisDriver;
use App\Http\Model\User;
use App\Libs\Helper\Func;
use Illuminate\Support\Facades\Cookie;

class UserActive
{
    /**
     * @param $user_info
     * @return bool
     * @throws \Exception
     */
    public static function restore($user_info)
    {
        $active_token = Func::createToken();

        Cookie::queue('active_token',$active_token,TIME + 86400);
        $cache_key = RedisDriver::getInstance()->getCacheKey('active.admin_user', $active_token);
        User::upInfoInWhere(['last_login_time'=>NOW_DATE]);
        return (boolean)RedisDriver::getInstance()->redis->setex($cache_key, 3600, json_encode($user_info));
    }

    /**
     * @param $user_info
     * @return bool
     * @throws \Exception
     */
    public static function check(&$user_info)
    {
        $active_token = Cookie::get('active_token');
        if (!$active_token) {
            return false;
        }

        $cache_key = RedisDriver::getInstance()->getCacheKey('active.admin_user', $active_token);
        $user_info = RedisDriver::getInstance()->redis->get($cache_key);

        if ($user_info == null) {
            return false;
        }

        $time = RedisDriver::getInstance()->redis->ttl($cache_key);
        if ($time < 1000) {
            RedisDriver::getInstance()->redis->setex($cache_key, 3600, $user_info);
        }

        $user_info = (array)json_decode($user_info);
        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public static function destroy()
    {
        $active_token = Cookie::get('active_token');
        Cookie::forget('active_token');
        $cache_key = RedisDriver::getInstance()->getCacheKey('active.admin_user', $active_token);
        return (boolean)RedisDriver::getInstance()->redis->del($cache_key);
    }
}