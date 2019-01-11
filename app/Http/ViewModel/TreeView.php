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

    private $root = <<<EOF
<ul class="uk-list">%s</ul>
EOF;

    private $branch = <<<EOF
<ul class="uk-list" style="border-left:1px solid #c6c6c6;margin-left: 1em">%s</ul>
EOF;

    private $leaves = <<<EOF
<li>
    <div>
    <div style="border-top:1px solid #c6c6c6;float: left;width: 30px;margin-left: -30px;margin-top: 20px"></div>
         <a href="javascript:void(0);" class="category_minus">
             <span style="position: relative;" uk-icon="icon: minus-circle; ratio: 0.7"></span></a>
             <button class="uk-button uk-button-default" style="padding: 0 10px;float: left"><div style="width: 80px;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">%s<div></button>
         <a href="javascript:void(0);" class="category_plus">
             <span style="position: relative;" uk-icon="icon: info; ratio: 0.7"></span></a>
         <div class="clear_both"></div>
    </div>
    %s
</li>
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
                $this->tree_view = sprintf($this->root,$item['name']);
                return;
            }else{
                $this->tree_view = sprintf($this->root,sprintf($this->leaves,$item['name'],$this->branch));
            }
        }

        foreach ($tree as $branch=>&$leaves){
            $shoot = [];
            foreach ($array as $key=>$value){
                if($value[$p_id] == $branch){
                    $leaves[$value[$id]] = [];
                    unset($array[$key]);
                    if(self::multiQuery2ArrayIndex($array,[$p_id=>$value[$id]]) === false){
                        //无子节点
                        $shoot[] = $this->makeBranch($value,false);
                    }else{
                        $shoot[] = $this->makeBranch($value);
                    }
                }
            }

            if(!empty($leaves) && $array){
                $this->tree_view = self::firstSprintf($this->tree_view,join('',$shoot));
                $this->makeTree($id,$p_id,$array,$leaves);
            }elseif (empty($leaves)){
                return;
            }else{
                $this->tree_view = self::firstSprintf($this->tree_view,join('',$shoot));
            }
        }
    }

    /**
     * 枝
     * @param $data
     * @param bool $node
     * @return string
     */
    private function makeBranch($data,$node = true)
    {
        if($node){
            return sprintf($this->leaves,$data['name'],$this->branch);
        }
        return sprintf($this->leaves,$data['name'],'');
    }

    /**
     * 首位sprintf
     * @param $string
     * @param string $aim
     * @param $value
     * @return bool|string
     */
    private static function firstSprintf($string,$value,$aim = '%s')
    {
        $position = strpos($string,$aim);
        $len = strlen($aim);
        $left = substr($string,0,$position + $len);
        $right = substr($string,$position + $len);
        return sprintf($left,$value).$right;
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