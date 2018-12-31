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
                        <td><input data-v={"id":{{$user['id']}}} name="name" style="width: 180px" maxlength="16"
                                   class="uk-input uk-form-width-medium uk-form-small" value="{{$user['name']}}"/></td>
                        <td><input data-v={"id":{{$user['id']}}} name="account" style="width: 180px" maxlength="16"
                                   class="uk-input uk-form-width-medium uk-form-small" value="{{$user['account']}}"/>
                        </td>
                        <td><input data-v={"id":{{$user['id']}}} name="password" style="width: 180px" maxlength="16"
                                   class="uk-input uk-form-width-medium uk-form-small" value="{{$user['password']}}"/>
                        </td>
                        <td>
                            <div class="uk-inline">
                                <select class="uk-select auto_select" style="height: 30px;">
                                    <option value="0">选择角色</option>
                                    @foreach($roles as $role)
                                        <option {{ $user['role_id'] == $role['id'] ? 'selected=selected' : '' }}
                                                data-v={"id":{{$user['id']}},"role_id":{{$role['id']}}}
                                                value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <button data-v={"id":{{$user['id']}}} class="uk-button uk-button-danger uk-button-small delete" type="button">删除用户</button>
                        </td>
                    </tr>
                @endforeach
                <tr class="input_update">
                    <td>新增角色</td>
                    <td>
                        <input name="name" style="width: 180px" maxlength="16"
                               class="uk-input uk-form-width-medium uk-form-small" placeholder="角色名"/>
                    </td>
                    <td>
                        <input name="account" style="width: 180px" maxlength="16"
                               class="uk-input uk-form-width-medium uk-form-small" placeholder="账号"/>
                    </td>
                    <td>
                        <input name="password" style="width: 180px" maxlength="16"
                               class="uk-input uk-form-width-medium uk-form-small" placeholder="密码"/>
                    </td>
                    <td>
                        <div class="uk-inline">
                            <select class="uk-select" style="height: 30px;">
                                <option value="0">选择角色</option>
                                @foreach($roles as $role)
                                    <option value="{{$role['id']}}">{{$role['name']}}</option>
                                @endforeach
                            </select>
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
            var url = '{{url('Auth.operateUser')}}';
            jinono.auto_input_update.init(url);
            jinono.input_update.init(url, {}, function () {
                $('.uk-select').change(function () {
                    var role_id = $(this).find("option:selected").val();
                    jinono.input_update.data['role_id'] = role_id;
                });
            });
            jinono.auto_select.init(url);
            jinono.delete.init('确定删除用户！',url,{'command':'del'});
        });
    </script>

@stop