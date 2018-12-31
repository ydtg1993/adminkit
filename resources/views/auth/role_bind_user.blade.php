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
                            <button data-v={"role_id":{{$user['role_id']}},"user_id":{{$user['user_id']}}}
                                    class="uk-button uk-button-danger uk-button-small delete" type="button">删除用户</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </p>
        </div>
    </div>

    <script>
        $(function () {
            jinono.delete.init('确定删除绑定用户！','{{url('Auth.roleBindUser')}}',{'command':'del'});
        })
    </script>
@stop