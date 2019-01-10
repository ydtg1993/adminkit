<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->match(['get','post'],'/login', 'Auth@login');
$router->post('logout', 'Auth@logout');

$router->group(['middleware' => 'CheckAdminLogin'], function () use ($router) {
    $router->get('/', 'Home@index');

    $router->get('Auth.menu', 'Auth@menu');
    $router->post('Auth.upMenu', 'Auth@upMenu');

    $router->get('Auth.role', 'Auth@role');

    $router->get('Auth.roleBindUser/{role_id}', 'Auth@roleBindUser');
    $router->post('Auth.roleBindUser', 'Auth@roleBindUser');

    $router->get('Auth.permission/{role_id}', 'Auth@permission');
    $router->post('Auth.permission', 'Auth@permission');

    $router->get('Auth.userList', 'Auth@userList');

    $router->post('Auth.operateUser', 'Auth@operateUser');
    $router->post('Auth.operateRole', 'Auth@operateRole');

    $router->get('Category', 'Category@index');
});