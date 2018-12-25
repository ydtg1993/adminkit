<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2018/12/22
 * Time: 11:55
 */

namespace App\Http\Dao;

use App\Http\Model\Permissions;
use App\Libs\Helper\Func;
use Symfony\Component\Console\Helper\Helper;

/**
 * 后台导航菜单
 * Class Menu
 * @package App\Http\Dao
 */
class Menu
{
    public static function getList($auth_permission_ids)
    {
        $routes = [];
        foreach (app()->routes->getRoutes() as $k=>$value){
            if($value->methods[0] == 'GET'){
                $action = $value->getAction();
                if(!isset($action['controller'])){
                    continue;
                }

                $routes[] = [
                    'controller'=>basename($action['controller']),
                    'uri'=>$value->uri
                ];
            }
        }

        $permissions = Permissions::getAllInIds(['view' => 1, 'access' => 0], $auth_permission_ids, 'sort');

        $p_navs = [];
        foreach ($permissions as $k=>$permission) {
            if ($permission['p_id'] == 0) {
                $nav_info = [
                    'id'=>$permission['id'],
                    'name'=>$permission['name'],
                    'navs'=>[]
                ];
                $p_navs[] = $nav_info;
                unset($permissions[$k]);
            }
        }

        foreach ($p_navs as &$p_nav){
            $p_id = $p_nav['id'];
            foreach ($permissions as &$permission){
                if($permission['p_id'] != $p_id){
                    continue;
                }

                $ac = $permission['controller'].'@'.$permission['action'];
                $route = Func::getQuery2Array($routes,['controller'=>$ac]);
                if(empty($route)){
                    throw new \Exception('没有配置路由:'.$ac);
                }
                $permission['link'] = $route['uri'];
                $p_nav['navs'][] = $permission;
            }
        }

        return $p_navs;
    }
}