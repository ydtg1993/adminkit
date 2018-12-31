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
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr class="auto_input_update">
                        <td>{{$role['id']}}</td>
                        <td><input data-id={"id":{{$role['id']}}} name="name" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" value="{{$role['name']}}" /></td>
                        <td><input data-id={"id":{{$role['id']}}} name="description" style="width: 180px" maxlength="16" class="uk-input uk-form-width-medium uk-form-small" value="{{$role['description']}}" /></td>
                        <td>
                            <button data-href="{{url('Auth.roleBindUser/'.$role['id'])}}" class="uk-button uk-button-default uk-button-small redirect_button" type="button">绑定用户</button>
                            <button data-href="{{url('Auth.permission/'.$role['id'])}}" class="uk-button uk-button-default uk-button-small redirect_button" type="button">权限设置</button>
                            <button data-v={"id":{{$role['id']}}} class="uk-button uk-button-danger uk-button-small delete" type="button">删除角色</button>
                        </td>
                    </tr>
                @endforeach
                <tr class="input_update">
                    <td>新增角色</td>
                    <td>
                        <input name="name" style="width: 180px" class="uk-input uk-form-width-medium uk-form-small" placeholder="角色名" />
                    </td>
                    <td>
                        <input name="description" style="width: 180px" class="uk-input uk-form-width-medium uk-form-small" placeholder="描述" />
                    </td>
                    <td>
                        <button class="uk-button uk-button-primary uk-button-small commit" type="button">保存角色</button>
                    </td>
                </tr>
                </tbody>
            </table>
            </p>
        </div>
    </div>
    <script>
        $(function () {
            jinono.auto_input_update.init('{{url('Auth.operateRole')}}');
            jinono.input_update.init('{{url('Auth.operateRole')}}');
            jinono.delete.init('确定删除角色！','{{url('Auth.operateRole')}}',{'command':'del'});
        });
    </script>
@stop