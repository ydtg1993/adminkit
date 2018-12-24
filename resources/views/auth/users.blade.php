@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
            <h3 class="uk-card-title">用户管理</h3>
            <p>
            <table class="uk-table uk-table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>名称</th>
                    <th>账号</th>
                    <th>密码</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user['id']}}</td>
                        <td>{{$user['name']}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td>新增角色</td>
                    <td>
                        <input name="name" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" placeholder="角色名" />
                    </td>
                    <td>
                        <input name="name" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" placeholder="账号" />
                    </td>
                    <td>
                        <input name="name" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" placeholder="密码" />
                    </td>
                </tr>
                </tbody>
            </table>
            </p>
        </div>
    </div>

@stop