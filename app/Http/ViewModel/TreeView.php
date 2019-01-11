<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11 0011
 * Time: 上午 11:40
 */

namespace App\Http\ViewModel;


class TreeView
{
    private $tree_view;

    private $branch = <<<EOF
<ul class="uk-list"><li>%s%s</li></ul>
EOF;

    private $leaves = <<<EOF
    <div>
         <a href="javascript:void(0);" class="category_minus">
             <span style="position: relative;" uk-icon="icon: minus; ratio: 1"></span></a>
         <label style="float: left">
             <button class="uk-button uk-button-default">%s</button>
         </label>
         <a href="javascript:void(0);" class="category_plus">
             <span style="position: relative;" uk-icon="icon: plus; ratio: 1"></span></a>
         <div class="clear_both"></div>
    </div>
EOF;

    public function index($data)
    {
        $this->makeTree('id','p_id',$data,$tree);
        return $this->tree_view;
    }

    /**
     * @param string $id
     * @param string $p_id
     * @param array $array
     * @param $tree
     */
    private function makeTree($id,$p_id,&$array,&$tree)
    {
        if(empty($array)){
            return;
        }

        if(empty($tree)){
            $item = array_shift($array);
            $tree[$item[$id]] = [];
            if(empty($array)){
                //无子节点
                $this->tree_view = sprintf('<ul class="uk-list"><li>%s</li></ul>',$item['name']);
                return;
            }else{
                $this->tree_view = sprintf('<ul class="uk-list"><li>%s%s</li></ul>',$item['name'],$this->branch);
            }
        }

        foreach ($tree as $branch=>&$leaves){
            $shoot = [];
            foreach ($array as $key=>$value){
                if($value[$p_id] == $branch){
                    $leaves[$value[$id]] = [];
                    unset($array[$key]);
                    if(self::multiQuery2ArrayIndex($array,[$p_id=>$value[$id]]) === false){
                        //无根节点
                        $shoot[] = sprintf($this->leaves,$value['name'],'');
                    }else{
                        $shoot[] = sprintf($this->leaves,$value['name'],$this->branch);
                    }
                }
            }

            if(!empty($leaves) && $array){
                $this->tree_view = sprintf($this->tree_view,join('',$shoot),$this->branch);
                $this->makeTree($id,$p_id,$array,$leaves);
            }else{
                $this->tree_view = sprintf($this->tree_view,join('',$shoot),'');
            }
        }
    }

    /**
     * 多条件查询二维数组索引
     *
     * @param $array
     * @param array $params
     * @return bool|int|string
     */
    private static function multiQuery2ArrayIndex(array $array, array $params)
    {
        $index = false;
        foreach ($array as $key=>$item) {
            $add = true;
            foreach ($params as $field => $value) {
                if ($item[$field] != $value) {
                    $add = false;
                }
            }
            if ($add) {
                $index = $key;
                break;
            }
        }

        return $index;
    }
}