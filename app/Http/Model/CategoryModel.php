<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


class CategoryModel extends BaseModel
{
    protected $table = 'category';

    public static function getCategoryTree()
    {
        $list = self::getAllWhere([],'p_id');
        makeTree('id','p_id',$list,$tree);

        return ['list'=>$list,'tree'=>$tree];
    }



}