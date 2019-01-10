<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/22 0022
 * Time: 下午 4:05
 */

namespace App\Http\Controllers;

use App\Http\Dao\UserActive;
use App\Http\Model\PermissionsModel;
use App\Http\Model\RolePermissionModel;
use App\Http\Model\RolesModel;
use App\Http\Model\UserModel;
use App\Http\Model\UserRoleModel;
use App\Libs\Helper\Func;

/**
 * Class Auth
 * @package App\Http\Controllers
 */
class Auth extends Controller
{
    public function login()
    {
        if (self::$REQUEST->method() == 'POST') {
            $account = self::$REQUEST->input('account');
            $password = self::$REQUEST->input('password');

            $user = UserModel::getInfoWhere(['account' => $account]);
            if (!$user) {
                return self::$RESPONSE->result(4001);
            }

            $pass = Func::packPassword($password, $user['token']);
            if ($user['password'] != $pass) {
                return self::$RESPONSE->result(4002);
            }
            UserActive::restore($user);
            return self::$RESPONSE->result(0);
        }

        return view('auth/login');
    }

    public function logout()
    {
        if (self::$REQUEST->ajax()) {
            UserActive::destroy();
            return self::$RESPONSE->result(0);
        }
    }

    public function menu()
    {
        $path = PROJECT_ROOT_PATH . DIRECTORY_SEPARATOR . str_replace("\\", "/", __NAMESPACE__) . '/*';
        $controllers = glob($path);

        $list = [];
        $permission_infos = PermissionsModel::getAllWhere();

        foreach ($controllers as $controller) {
            $class_name = str_replace('.php', '', basename($controller));
            $class = __NAMESPACE__ . '\\' . $class_name;
            $object = new \ReflectionClass($class);

            $methods = $object->getMethods(\ReflectionMethod::IS_PUBLIC);
            $traits = $object->getTraits();

            $traits_methods = [];
            foreach ($traits as $trait) {
                $trait_methods = $trait->getMethods();
                foreach ($trait_methods as $traits_method) {
                    $traits_methods[] = $traits_method->name;
                }
            }

            foreach ($methods as $method) {
                $method_name = $method->getName();
                if ($method->isConstructor()) {
                    continue;
                }
                $declare_class = $method->getDeclaringClass();

                if ($declare_class->name != $class) {
                    continue;
                }

                if ($traits_methods && in_array($method_name, $traits_methods)) {
                    continue;
                }

                $permission_info_index = Func::multiQuery2ArrayIndex($permission_infos, ['controller' => $class_name, 'action' => $method_name]);
                if (is_int($permission_info_index)) {
                    $permission_info = $permission_infos[$permission_info_index];
                    $permission_infos[$permission_info_index]['exists'] = true;
                    $data = $permission_info;
                } else {
                    //自动添加
                    $data = $this->addMenu($class_name, $method_name);
                }

                $list[$class_name][] = $data;
            }

            if (empty($list[$class_name])) {
                continue;
            }
            $p_data = Func::getQuery2Array($permission_infos, ['controller' => $class_name, 'p_id' => 0]);
            if (empty($p_data)) {
                $p_data = PermissionsModel::getInfoWhere(['controller' => $class_name, 'p_id' => 0]);
            }
            $p_data['exists'] = true;
            array_unshift($list[$class_name], $p_data);
        }
        //自动清除
        foreach ($permission_infos as $permission_info) {
            if (!isset($permission_info['exists']) && $permission_info['p_id']) {
                PermissionsModel::delInfoWhere(['id' => $permission_info['id']]);
            }
        }

        self::$data['list'] = $list;
        return view('auth/menu', self::$data);
    }

    private function addMenu($class_name, $method_name)
    {
        $data = [
            'controller' => $class_name,
            'action' => $method_name,
            'name' => '',
            'access' => 0,
            'view' => 0,
            'sort' => 0,
            'description' => ''
        ];
        $p_nav = PermissionsModel::getInfoWhere(['controller' => $class_name, 'p_id' => 0]);
        if ($p_nav) {
            $p_id = $p_nav['id'];
        } else {
            $p_id = PermissionsModel::add([
                'p_id' => 0,
                'controller' => $class_name,
                'action' => '',
                'name' => $class_name,
                'access' => 0,
                'view' => 0,
                'sort' => 0
            ]);
        }

        $data['p_id'] = $p_id;
        $id = PermissionsModel::add($data);
        $data['id'] = $id;
        return $data;
    }

    public function upMenu()
    {
        if (self::$REQUEST->ajax()) {
            $id = self::$REQUEST->input('id');

            $data = [];
            if (self::$REQUEST->has('name')) {
                $data['name'] = (string)self::$REQUEST->input('name');
            }
            if (self::$REQUEST->has('description')) {
                $data['description'] = (string)self::$REQUEST->input('description');
            }
            if (self::$REQUEST->has('sort')) {
                $data['sort'] = (int)self::$REQUEST->input('sort');
            }
            if (self::$REQUEST->has('view')) {
                $data['view'] = (int)self::$REQUEST->input('view');
            }
            PermissionsModel::upInfoWhere($data, ['id' => $id]);

            return self::$RESPONSE->result(0);
        }
    }

    public function userList()
    {
        $users = UserModel::getAllWithRoleWhere();
        $roles = RolesModel::getAllWhere();

        foreach ($users as &$user) {
            $user['role_name'] = '';
            $result = Func::getQuery2Array($roles, ['id' => $user['role_id']]);
            if (!$result) {
                continue;
            }
            $user['role_name'] = $result['name'];
        }

        self::$data['roles'] = $roles;
        self::$data['users'] = $users;
        return view('auth/users', self::$data);
    }

    public function operateUser()
    {
        if (self::$REQUEST->ajax()) {
            $data = [];
            $token = Func::createToken();
            if (!self::$REQUEST->has('id')) {
                //add
                if (!self::$REQUEST->has('name')) {
                    return self::$RESPONSE->result(5001);
                }
                if (!self::$REQUEST->has('account')) {
                    return self::$RESPONSE->result(5001);
                }
                if (!self::$REQUEST->has('password')) {
                    return self::$RESPONSE->result(5001);
                }

                $user_id = UserModel::add([
                    'name' => self::$REQUEST->input('name'),
                    'account' => self::$REQUEST->input('account'),
                    'token' => $token,
                    'password' => Func::packPassword(self::$REQUEST->input('password'), $token)
                ]);
                if (!$user_id) {
                    return self::$RESPONSE->result(5005);
                }
                if (self::$REQUEST->has('role_id')) {
                    UserRoleModel::add([
                        'user_id' => $user_id,
                        'role_id' => self::$REQUEST->input('role_id')
                    ]);
                }

                return self::$RESPONSE->result(0);
            }

            $user_id = self::$REQUEST->input('id');
            $command = self::$REQUEST->input('command');
            //del
            if ($command == 'del') {
                $result = UserModel::delInfoWhere(['id' => $user_id]);
                if (!$result) {
                    return self::$RESPONSE->result(5005);
                }
                $result = UserRoleModel::delInfoWhere(['user_id' => $user_id]);
                if (!$result) {
                    return self::$RESPONSE->result(5005);
                }
                return self::$RESPONSE->result(0);
            }
            //update
            if (self::$REQUEST->has('role_id')) {
                $result = UserRoleModel::updateOrCreate([
                    'user_id' => $user_id,
                ], [
                    'user_id' => $user_id,
                    'role_id' => self::$REQUEST->input('role_id')
                ]);
                if (!$result) {
                    return self::$RESPONSE->result(5005);
                }
                return self::$RESPONSE->result(0);
            }

            if (self::$REQUEST->has('name')) {
                $data['name'] = self::$REQUEST->input('name');
            }
            if (self::$REQUEST->has('account')) {
                $data['account'] = self::$REQUEST->input('account');
            }
            if (self::$REQUEST->has('password')) {
                $token = UserModel::getInfoWhere(['id' => $user_id], ['token'])['token'];
                $data['password'] = Func::packPassword(self::$REQUEST->input('password'), $token);
            }
            $result = UserModel::upInfoWhere($data, ['id' => $user_id]);
            if (!$result) {
                return self::$RESPONSE->result(5005);
            }
            return self::$RESPONSE->result(0);
        }
    }

    public function role()
    {
        $roles = RolesModel::getAllWhere();

        self::$data['roles'] = $roles;
        return view('auth/roles', self::$data);
    }

    public function operateRole()
    {
        if (self::$REQUEST->ajax()) {
            if (!self::$REQUEST->has('id')) {
                //add
                if (!self::$REQUEST->has('name')) {
                    return self::$RESPONSE->result(5001);
                }
                if (!self::$REQUEST->has('description')) {
                    return self::$RESPONSE->result(5001);
                }
                $id = RolesModel::add([
                    'name' => self::$REQUEST->input('name'),
                    'description' => self::$REQUEST->input('description')
                ]);
                if (!$id) {
                    return self::$RESPONSE->result(5005);
                }

                return self::$RESPONSE->result(0);
            }
            $id = self::$REQUEST->input('id');
            $command = self::$REQUEST->input('command');

            //del
            if ($command == 'del') {
                $result = RolesModel::delInfoWhere(['id' => $id]);
                if (!$result) {
                    return self::$RESPONSE->result(5005);
                }
                $result = RolePermissionModel::delInfoWhere(['role_id' => $id]);
                if (!$result) {
                    return self::$RESPONSE->result(5005);
                }
                return self::$RESPONSE->result(0);
            }

            $data = [];
            if (self::$REQUEST->has('name')) {
                $data['name'] = self::$REQUEST->input('name');
            }
            if (self::$REQUEST->has('description')) {
                $data['description'] = self::$REQUEST->input('description');
            }

            RolesModel::upInfoWhere($data, ['id' => $id]);
            return self::$RESPONSE->result(0);
        }
    }

    public function roleBindUser()
    {
        if (self::$REQUEST->ajax()) {
            $role_id = self::$REQUEST->input('role_id');
            $user_id = self::$REQUEST->input('user_id');
            $command = self::$REQUEST->input('command');
            if ($command == 'add') {
                $result = UserRoleModel::add(['role_id' => $role_id, 'user_id' => $user_id]);
            } elseif ($command == 'del') {
                $result = UserRoleModel::delInfoWhere(['role_id' => $role_id, 'user_id' => $user_id]);
            }else{
                return self::$RESPONSE->result(5005);
            }
            if (!$result) {
                return self::$RESPONSE->result(5005);
            }
            return self::$RESPONSE->result(0);
        }

        $role_id = self::$REQUEST->route('role_id');
        $role = RolesModel::getInfoWhere(['id' => $role_id]);
        $users = UserRoleModel::getAllWithUser(['role_id' => $role_id]);

        self::$data['role'] = $role;
        self::$data['users'] = $users;
        return view('auth/role_bind_user', self::$data);
    }

    public function permission()
    {
        if (self::$REQUEST->ajax()) {
            $role_id = self::$REQUEST->input('role_id');
            $permission_id = self::$REQUEST->input('id');
            $select = self::$REQUEST->input('select');
            $controller = self::$REQUEST->input('controller');
            $checked = self::$REQUEST->input('checked');

            $add_permissions_data = [];
            $del_permissions_data = [];
            //批量
            if (self::$REQUEST->has('controller')) {
                $all_permissions = RolePermissionModel::getAllPermissionOfController($controller);
                foreach ($all_permissions as $permission) {
                    if ($permission['role_id'] != $role_id) {
                        $add_permissions_data[] = [
                            'role_id' => (int)$role_id,
                            'permission_id' => $permission['id']
                        ];
                    }elseif ($permission['role_id'] == $role_id){
                        $del_permissions_data[] = [
                            'role_id' => (int)$role_id,
                            'permission_id' => $permission['id']
                        ];
                    }
                }
                $result = false;
                if($checked == 1 && $add_permissions_data){
                    $result = RolePermissionModel::batchAdd($add_permissions_data);
                }elseif($checked == 0 && $del_permissions_data){
                    $result = RolePermissionModel::batchDel($del_permissions_data);
                }
                if (!$result) {
                    return self::$RESPONSE->result(5005);
                }
                return self::$RESPONSE->result(0);
            }
            //add
            if ($select == 1) {
                $result = RolePermissionModel::add(['role_id' => $role_id, 'permission_id' => $permission_id]);
                if (!$result) {
                    return self::$RESPONSE->result(5005);
                }
                return self::$RESPONSE->result(0);
            }
            //del
            $result = RolePermissionModel::delInfoWhere(['role_id' => $role_id, 'permission_id' => $permission_id]);
            if (!$result) {
                return self::$RESPONSE->result(5005);
            }
            return self::$RESPONSE->result(0);
        }

        $role_id = self::$REQUEST->route('role_id');
        self::$data['role'] = RolesModel::getInfoWhere(['id' => $role_id]);

        $all_permissions = PermissionsModel::getAllWhere();

        $role_permissions = RolePermissionModel::getAllWhere(['role_id' => $role_id]);
        $role_permission_ids = array_column($role_permissions, 'permission_id');

        $permissions = [];
        foreach ($all_permissions as $permission) {
            $permission['isset'] = 0;
            if(!isset($permissions[$permission['controller']]['all']) || $permissions[$permission['controller']]['all'] == 1) {
                $permissions[$permission['controller']]['all'] = 1;
            }
            if (in_array($permission['id'], $role_permission_ids)) {
                $permission['isset'] = 1;
            }else{
                $permissions[$permission['controller']]['all'] = 0;
            }

            $permissions[$permission['controller']][] = $permission;
        }

        self::$data['permissions'] = $permissions;
        return view('auth/permission', self::$data);
    }
}