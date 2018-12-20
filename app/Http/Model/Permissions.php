<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class Permissions extends BaseModel
{
    protected $table = 'permissions';

    public static function getAllInIds(array $where = [],array $ids = [])
    {
        return self::where($where)
            ->whereIn('id',$ids)
            ->get();
    }
}