@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
            <h3 class="uk-card-title">角色管理</h3>
            <p>
            <table class="uk-table uk-table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role['id']}}</td>
                        <td>{{$role['name']}}</td>
                        <td>
                            <a href="{{url('Auth.roleBindUser/'.$role['id'])}}" type="button">绑定用户</a>
                            <a href="{{url('Auth.permission/'.$role['id'])}}" type="button">权限设置</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </p>
        </div>
    </div>

@stop