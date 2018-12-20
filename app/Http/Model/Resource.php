<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class Resource extends BaseModel
{
    protected $table = 'resource';

    const MAIN_TYPE_COURSE = 1;
    const MAIN_TYPE_NOTE = 2;

    public static function findListWithUser(array $where = [],$page = 1,$limit = 30,$order_by = 'resource.id',$sort = 'ASC')
    {
        $page-=$page;
        $start = $page * $limit;
        return self::where($where)
            ->join('users','resource.author_id','=','users.id')
            ->selectRaw('resource.*,users.id,users.name,users.avatar')
            ->offset($start)->limit($limit)->orderBy($order_by, $sort)->get();
    }

    public static function getInfoWhere(array $where = [])
    {
        return self::join('resource_extend','resource.id','=','resource_extend.id')->where($where)->first();
    }

    public function extend()
    {
        return $this->belongsTo('App\Http\Model\ResourceExtend','id','id');
    }
}