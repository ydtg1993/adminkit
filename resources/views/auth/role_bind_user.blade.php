@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
            <h3 class="uk-card-title">角色绑定</h3>
            <p>
            <table class="uk-table uk-table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>user_id</th>
                    <th>角色id</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr data-id="{{$user['role_id']}}">
                        <td>{{$user['id']}}</td>
                        <td>{{$user['user_id']}}</td>
                        <td>{{$user['role_id']}}</td>
                        <td>
                            <a type="button" data-usr="{{$user['user_id']}}">删除</a>
                        </td>
                    </tr>
                @endforeach
                <tr data-id="{{$user['role_id']}}">
                    <td>新增用户</td>
                    <td>
                        <div class="uk-margin">
                            <input name="user_id" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" placeholder="user_id" />
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            </p>
        </div>
    </div>

    <script>

    </script>
@stop