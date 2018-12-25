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
                            <button data-href="{{url('Auth.roleBindUser/'.$role['id'])}}" class="uk-button uk-button-default uk-button-small" type="button">绑定用户</button>
                            <button data-href="{{url('Auth.permission/'.$role['id'])}}" class="uk-button uk-button-default uk-button-small" type="button">权限设置</button>
                            <button class="uk-button uk-button-danger uk-button-small" type="button">删除角色</button>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>新增角色</td>
                    <td>
                        <input name="name" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" placeholder="角色名" />
                    </td>
                </tr>
                </tbody>
            </table>
            </p>
        </div>
    </div>

    <script>
        $(function () {

        });
    </script>
@stop