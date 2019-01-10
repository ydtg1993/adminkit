<?php

namespace App\Http\Middleware;

use App\Http\Common\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Dao\Menu;
use App\Http\Dao\UserActive;
use App\Http\Model\PermissionsModel;
use App\Http\Model\RolePermissionModel;
use App\Http\Model\UserRoleModel;
use Closure;
use Illuminate\Support\Facades\Redirect;

class CheckAdmin
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        //登录检查
        $is_login = UserActive::check($user_info);
        if(!$is_login){
            return Redirect::to('login');
        }
        Controller::$data['user_info'] = $user_info;

        //权限检查
        $user_role = UserRoleModel::getInfoWhere(['user_id'=>$user_info['id']]);
        if(!$user_role){
            if($request->ajax()){
                return ResponseCode::getInstance()->result(4100);
            }
            return response()->view('error', ['message'=>config('code')[4100],'code'=>4100]);
        }

        $request_info = $request->route()->getAction();;
        $slug = basename($request_info['controller']);
        Controller::$data['slug'] = $slug;
        $slug_info = explode('@',$slug);
        $controller = $slug_info[0];
        $action = $slug_info[1];
        $permission = PermissionsModel::getInfoWhere(['controller'=>$controller,'action'=>$action]);

        $auths = RolePermissionModel::getAllWhere(['role_id'=>$user_role['role_id']]);
        $auth_permission_ids = array_column($auths,'permission_id');

        if($permission){
            if(!in_array($permission['id'],$auth_permission_ids)){
                if($request->ajax()){
                    return ResponseCode::getInstance()->result(4101);
                }
                return response()->view('error', ['message'=>config('code')[4101],'code'=>4101]);
            }
        }else{
            if($request->ajax()){
                return ResponseCode::getInstance()->result(4102);
            }
            return response()->view('error', ['message'=>config('code')[4102],'code'=>4102]);
        }

        Controller::$data['head'] = $permission['name'];
        //权限导航
        Controller::$data['navigation'] = Menu::getList($auth_permission_ids);

        return $next($request);
    }
}
