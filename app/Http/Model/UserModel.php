<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class UserModel extends BaseModel
{
    protected $table = 'users';

    public static function getAllWithRoleWhere(array $where = [])
    {
        $data= self::where($where)->leftJoin('user_role', 'users.id', '=', 'user_role.user_id')
            ->select(['users.*','user_role.role_id'])
            ->get();
        if($data){
            return $data->toArray();
        }
        return [];
    }
}