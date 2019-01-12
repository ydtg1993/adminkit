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

    private $element = ["name","value","sort"];

    private $root = <<<EOF
<ul class="uk-list treeView uk-animation-toggle">%s</ul>
EOF;

    private $branch = <<<EOF
<ul class="uk-list" style="border-left:1px solid #c6c6c6;margin-left: 1em">%s</ul>
EOF;

    private $leaf = <<<EOF
<li>
    <div data-v=%s>
    <div style="border-top:1px solid #c6c6c6;float: left;width: 30px;margin-left: -30px;margin-top: 20px"></div>
         <a href="javascript:void(0);" class="tree_retract" data-sign="1">
             <span style="position: relative;" uk-icon="icon: minus-circle; ratio: 0.7"></span></a>
             <button class="uk-button uk-button-default" style="height:40px;padding: 0 10px;float: left">
                <div style="width: 80px;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">%s<div>
             </button>
         <a href="javascript:void(0);" class="tree_grow">
             <span style="position: relative;" uk-icon="icon: info; ratio: 0.7"></span></a>
         <div class="clear_both"></div>
    </div>
    %s
</li>
EOF;

    private $leaf_apex = <<<EOF
<li>
    <div data-v=%s>
    <div style="border-top:1px solid #c6c6c6;float: left;width: 30px;margin-left: -30px;margin-top: 20px"></div>
         <a href="javascript:void(0);" class="tree_ban">
             <span style="position: relative;" uk-icon="icon: ban; ratio: 0.7"></span></a>
             <button class="uk-button uk-button-default" style="height:40px;padding: 0 10px;float: left" href="#modal-overflow" uk-toggle>
                <div style="width: 80px;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">%s<div>
             </button>
         <a href="javascript:void(0);" class="tree_grow">
             <span style="position: relative;" uk-icon="icon: info; ratio: 0.7"></span></a>
         <div class="clear_both"></div>
    </div>
    %s
</li>
EOF;

    private $form = <<<EOF
<div id="modal-overflow" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Headline</h2>
        </div>
        <div class="uk-modal-body">
            %s
        </div>
        <div class="uk-modal-footer uk-text-right"> 
            <button class="uk-button uk-button-danger" type="button">删除</button>
        </div>
    </div>
</div>
EOF;


    public function index($data)
    {
        $this->makeTree('id','p_id',$data,$tree);
        return $this->tree_view;
    }

    private function makeForm()
    {

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
                $this->tree_view = sprintf($this->root,sprintf($this->leaf_apex,arrayToJsonString($item),$item['name'],''));
                return;
            }else{
                $this->tree_view = sprintf($this->root,sprintf($this->leaf,arrayToJsonString($item),$item['name'],$this->branch));
            }
        }

        foreach ($tree as $branch=>&$leaves){
            $shoot = [];
            foreach ($array as $key=>$value){
                if($value[$p_id] == $branch){
                    $leaves[$value[$id]] = [];
                    unset($array[$key]);
                    if(quadraticArrayGetIndex($array,[$p_id=>$value[$id]]) === false){
                        //无子节点
                        $shoot[] = $this->makeBranch($value,false);
                    }else{
                        $shoot[] = $this->makeBranch($value);
                    }
                }
            }

            if(!empty($leaves) && $array){
                $this->tree_view = firstSprintf($this->tree_view,join('',$shoot));
                $this->makeTree($id,$p_id,$array,$leaves);
            }elseif (empty($leaves)){
                return;
            }else{
                $this->tree_view = firstSprintf($this->tree_view,join('',$shoot));
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
            return sprintf($this->leaf,arrayToJsonString($data),$data['name'],$this->branch);
        }
        return sprintf($this->leaf_apex,arrayToJsonString($data),$data['name'],'');
    }
}