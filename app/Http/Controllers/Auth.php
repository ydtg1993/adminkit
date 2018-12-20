<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/22 0022
 * Time: 下午 4:05
 */

namespace App\Http\Controllers;


use App\Http\Model\Permissions;
use App\Http\Model\RolePermission;
use App\Http\Model\Roles;
use App\Http\Model\UserRole;
use App\Libs\Helper\Func;

class Auth extends Admin
{
    public function menu()
    {
        $path = dirname(PROJECT_ROOT_PATH) . DIRECTORY_SEPARATOR . 'app/Http/Controllers/*';
        $controllers = glob($path);

        $list = [];
        $permission_infos = Permissions::getAllWhere();

        foreach ($controllers as $controller) {
            $class_name = str_replace('.php', '', basename($controller));
            $class = __NAMESPACE__ . '\\' . $class_name;
            $object = new \ReflectionClass($class);

            $methods = $object->getMethods(\ReflectionMethod::IS_PUBLIC);
            $traits = $object->getTraits();

            $traits_methods = [];
            foreach ($traits as $trait){
                $trait_methods = $trait->getMethods();
                foreach ($trait_methods as $traits_method){
                    $traits_methods[] = $traits_method->name;
                }
            }

            foreach ($methods as $method) {
                $method_name = $method->getName();
                if ($method->isConstructor()) {
                    continue;
                }
                $declare_class = $method->getDeclaringClass();

                if($declare_class->name != $class){
                    continue;
                }

                if($traits_methods && in_array($method_name,$traits_methods)){
                    continue;
                }

                $c_n_name = $class_name . '.' . $method_name;
                $permission_info_index = Func::multiQuery2ArrayIndex($permission_infos,['slug'=>$c_n_name]);
                if (is_int($permission_info_index)) {
                    $permission_info = $permission_infos[$permission_info_index];
                    $permission_infos[$permission_info_index]['exists'] = true;
                    $data = [
                        'id' => $permission_info['id'],
                        'c_name' => $permission_info['c_name'],
                        'm_name' => $permission_info['m_name'],
                        'slug' => $permission_info['slug'],
                        'description' => $permission_info['description'],
                        'access' => $permission_info['access'],
                        'view' => $permission_info['view']
                    ];
                } else {
                    $id = Permissions::add([
                        'controller'=>$class_name,
                        'c_name' => '',
                        'm_name' => '',
                        'slug' => $c_n_name,
                        'description' => '',
                        'access' => 0,
                        'view' => 0
                    ]);
                    $data = [
                        'id' => $id,
                        'c_name' => '',
                        'm_name' => '',
                        'slug' => $c_n_name,
                        'description' => '',
                        'access' => 0,
                        'view' => 0
                    ];
                }

                $list[$class_name][] = $data;
            }
        }

        foreach ($permission_infos as $permission_info){
            if (!isset($permission_info['exists'])){
                Permissions::delInfoWhere(['id'=>$permission_info['id']]);
            }
        }

        self::$data['list'] = $list;
        return view('auth/menu', self::$data);
    }

    public function upMenu()
    {
        if(self::$REQUEST->ajax()){
            $id = self::$REQUEST->input('id');

            $data = [];
            if(self::$REQUEST->has('c_name')){
                $data['c_name'] = self::$REQUEST->input('c_name');
                $permission_info = Permissions::getInfoWhere(['id'=>$id]);
                $permission_infos = Permissions::getAllWhere(['controller'=>$permission_info->controller]);
                $ids = array_column($permission_infos,'id');
                Permissions::upInfoInWhere($data,$ids,'id');
                return self::$RESPONSE->result(0);
            }
            if(self::$REQUEST->has('m_name')){
                $data['m_name'] = self::$REQUEST->input('m_name');
            }
            if(self::$REQUEST->has('description')){
                $data['description'] = self::$REQUEST->input('description');
            }
            if(self::$REQUEST->has('view')){
                $data['view'] = (int)(boolean)self::$REQUEST->input('view');
            }
            Permissions::upInfoWhere($data,['id'=>$id]);

            return self::$RESPONSE->result(0);
        }
    }

    public function role()
    {
        $roles = Roles::getAllWhere();

        self::$data['roles'] = $roles;
        return view('auth/roles', self::$data);
    }

    public function roleBindUser()
    {
        if(self::$REQUEST->ajax()){
            $role_id = self::$REQUEST->input('role_id');
            $user_id = self::$REQUEST->input('user_id');
            $command = self::$REQUEST->input('command');
            if($command == 'add'){
                UserRole::add(['role_id'=>$role_id,'user_id'=>$user_id]);
            }elseif ($command == 'del'){
                UserRole::delInfoWhere(['role_id'=>$role_id,'user_id'=>$user_id]);
            }

            return self::$RESPONSE->result(0);
        }

        $role_id = self::$REQUEST->route('role_id');
        $users = UserRole::getAllWhere(['role_id'=>$role_id]);

        self::$data['users'] = $users;
        return view('auth/role_bind_user', self::$data);
    }

    public function permission()
    {
        if(self::$REQUEST->ajax()){
            $role_id = self::$REQUEST->input('role_id');
            $permission_id = self::$REQUEST->input('permission_id');
            $command = self::$REQUEST->input('command');

            $result = false;
            if($command == 'add'){
                $result = RolePermission::add(['role_id'=>$role_id,'permission_id'=>$permission_id]);
            }elseif ($command == 'del'){
                $result = RolePermission::delInfoWhere(['role_id'=>$role_id,'permission_id'=>$permission_id]);
            }

            if(!$result){
                return self::$RESPONSE->result(5005);
            }

            return self::$RESPONSE->result(0);
        }
        $role_id = self::$REQUEST->route('role_id');
        self::$data['role'] = Roles::getInfoWhere(['id'=>$role_id]);

        $all_permissions = Permissions::getAllWhere();

        $role_permissions = RolePermission::getAllWhere(['role_id'=>$role_id]);
        $role_permission_ids = array_column($role_permissions,'permission_id');

        $permissions = [];
        foreach ($all_permissions as $permission){
            $permission['isset'] = 0;
            if(in_array($permission['id'],$role_permission_ids)){
                $permission['isset'] = 1;
            }
            $permissions[$permission['controller']][] = $permission;
        }

        self::$data['permissions'] = $permissions;
        return view('auth/permission', self::$data);
    }

}