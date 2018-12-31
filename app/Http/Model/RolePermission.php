<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class RolePermission extends BaseModel
{
    protected $table = 'role_permission';

    public static function getAllPermissionToRole($p_id)
    {
        return self::rightJoin('permissions','role_permission.permission_id','=','permissions.id')
            ->where(['permissions.p_id'=>$p_id])
            ->select('permissions.id','permissions.p_id','role_permission.role_id','role_permission.permission_id')
            ->get()->toArray();
    }
}