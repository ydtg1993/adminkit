<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class UserRoleModel extends BaseModel
{
    protected $table = 'user_role';

    public static function getAllWithUser(array $where = [])
    {
        $data = self::join('users','users.id', '=', 'user_role.user_id')
            ->where($where)
            ->select('users.name', 'users.account', 'user_role.*')->get();
        if($data){
            return $data->toArray();
        }

        return [];
    }
}