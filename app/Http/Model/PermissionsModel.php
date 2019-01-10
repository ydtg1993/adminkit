<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class PermissionsModel extends BaseModel
{
    protected $table = 'permissions';

    public static function getAllInIds(array $where = [],array $ids = [],$order_by = 'id',$sort = 'ASC')
    {
        return self::where($where)
            ->whereIn('id',$ids)
            ->orderBy($order_by, $sort)
            ->get()->toArray();
    }
}