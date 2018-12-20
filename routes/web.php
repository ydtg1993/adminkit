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

Route::match(['get','post'],'/login', 'Admin@login');

$router->group(['middleware' => 'CheckAdminLogin'], function ($router) {
    $router->match(['get'],'/', 'Admin@index');

    $router->get('/Managers.list', 'ManagerController@list');

    $router->get('/Admin.index', 'Admin@index');
    $router->get('Admin@index');

    $router->get('/Auth.menu', 'Auth@menu');
    $router->post('/Auth.upMenu', 'Auth@upMenu');

    $router->get('/Auth.role', 'Auth@role');

    $router->get('/Auth.roleBindUser/{role_id}', 'Auth@roleBindUser');
    $router->post('/Auth.roleBindUser', 'Auth@roleBindUser');

    $router->get('/Auth.permission/{role_id}', 'Auth@permission');
    $router->post('/Auth.permission', 'Auth@permission');
});
