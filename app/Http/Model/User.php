<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class User extends BaseModel
{
    protected $table = 'users';

    public static function getAllWithRoleWhere(array $where = [])
    {
        $data= self::where($where)->leftJoin('user_role', 'users.id', '=', 'user_role.user_id')->get();
        if($data){
            return $data->toArray();
        }
        return [];
    }
}