<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2018/12/22
 * Time: 11:55
 */

namespace App\Http\Dao;

use App\Http\Model\PermissionsModel;

/**
 * 后台导航菜单
 * Class Menu
 * @package App\Http\Dao
 */
class Menu
{
    /**
     * @param $auth_permission_ids
     * @return array
     * @throws \Exception
     */
    public static function getList($auth_permission_ids)
    {
        $routes = [];
        foreach (app()->routes->getRoutes() as $k => $value) {
            if ($value->methods[0] == 'GET') {
                $action = $value->getAction();
                if (!isset($action['controller'])) {
                    continue;
                }

                $routes[] = [
                    'controller' => basename($action['controller']),
                    'uri' => $value->uri
                ];
            }
        }

        $permissions = PermissionsModel::getAllInIds(['view' => 1, 'access' => 0], $auth_permission_ids, 'sort');

        $p_navs = [];
        foreach ($permissions as $k => $permission) {
            if ($permission['p_id'] == 0) {
                $nav_info = [
                    'id' => $permission['id'],
                    'name' => $permission['name'] ? $permission['name'] : $permission['controller'],
                    'navs' => []
                ];
                $p_navs[] = $nav_info;
                unset($permissions[$k]);
            }
        }

        foreach ($p_navs as &$p_nav) {
            $p_id = $p_nav['id'];
            foreach ($permissions as &$permission) {
                if ($permission['p_id'] != $p_id) {
                    continue;
                }

                $ac = $permission['controller'] . '@' . $permission['action'];
                $route = quadraticArrayQuery($routes, ['controller' => $ac]);
                if (empty($route)) {
                    PermissionsModel::upInfoWhere(['view'=>0],['controller'=>$permission['controller'],'action'=>$permission['action']]);
                    throw new \Exception('导航菜单没有设置路由:' . $ac);
                }
                $permission['link'] = $route['uri'];
                if(!$permission['name']){
                    $permission['name'] = $permission['action'];
                }
                $p_nav['navs'][] = $permission;
            }
        }

        return $p_navs;
    }
}