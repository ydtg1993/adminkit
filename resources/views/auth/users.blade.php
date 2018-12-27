@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
            <p>
            <table class="uk-table uk-table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>名称</th>
                    <th>账号</th>
                    <th>密码</th>
                    <th>角色</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="auto_input_update">
                        <td>{{$user['id']}}</td>
                        <td><input data-id="{{$user['id']}}" name="name" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" value="{{$user['name']}}" /></td>
                        <td><input data-id="{{$user['id']}}" name="account" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" value="{{$user['account']}}" /></td>
                        <td><input data-id="{{$user['id']}}" name="password" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" value="{{$user['password']}}" /></td>
                        <td>
                            <div class="uk-inline">
                                <button class="uk-button uk-button-secondary uk-button-small" type="button">{{$user['role_name'] ? $user['role_name'] : '请选择角色'}}</button>
                                <div uk-dropdown="mode: click">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        @foreach($roles as $role)
                                        <li {{ $user['role_id'] == $role['id'] ? 'class=uk-active' : '' }}><a href="javascript:void(0);">{{$role['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td>
                            <button class="uk-button uk-button-danger uk-button-small" type="button">删除用户</button>
                        </td>
                    </tr>
                @endforeach
                <tr class="input_update">
                    <td>新增角色</td>
                    <td>
                        <input name="name" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" placeholder="角色名" />
                    </td>
                    <td>
                        <input name="account" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" placeholder="账号" />
                    </td>
                    <td>
                        <input name="password" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" placeholder="密码" />
                    </td>
                    <td>
                        <div class="uk-inline">
                            <button class="uk-button uk-button-secondary uk-button-small" type="button">请选择角色</button>
                            <div uk-dropdown="mode: click">
                                <ul class="uk-nav uk-dropdown-nav">
                                    @foreach($roles as $role)
                                        <li><a href="javascript:void(0);">{{$role['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button class="uk-button uk-button-primary uk-button-small commit" type="button">保存信息</button>
                    </td>
                </tr>
                </tbody>
            </table>
            </p>
        </div>
    </div>
    <script>
        $(function () {
            jinono.auto_input_update.init('{{url('Auth.operateUser')}}');
            jinono.input_update.init('{{url('Auth.operateUser')}}');
        });
    </script>

@stop