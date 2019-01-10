<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 上午 11:57
 */

namespace App\Http\Model;


use App\Libs\Helper\Func;

class CategoryModel extends BaseModel
{
    protected $table = 'category';

    public static function getCategoryTree()
    {
        $list = self::getAllWhere([],'p_id');
        self::makeTree($list,$tree);

        return ['list'=>$list,'tree'=>$tree];
    }

    private static function makeTree(&$array,&$tree = [])
    {
        if(empty($array)){
            return;
        }

        if(empty($tree)){
            $item = array_shift($array);
            $tree[$item['id']] = [];
        }

        foreach ($tree as $branch=>&$leaves){
            foreach ($array as $key=>$value){
                if($value['p_id'] == $branch){
                    $leaves[$value['id']] = [];
                    unset($array[$key]);
                }
            }

            if(!empty($leaves)){
                self::makeTree($array,$leaves);
            }
        }
    }

}