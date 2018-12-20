@extends('layouts.master')

@section('title', 'jinono')

@section('container')
    <div style="padding: 10px">
        <div class="box">
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>id</th>
                        <th>user_id</th>
                        <th>角色id</th>
                        <th>操作</th>
                    </tr>
                    @foreach($users as $user)
                        <tr data-id="{{$user['role_id']}}">
                            <td>{{$user['id']}}</td>
                            <td>{{$user['user_id']}}</td>
                            <td>{{$user['role_id']}}</td>
                            <td>
                                <a type="button" data-usr="{{$user['user_id']}}" class="btn btn-default btn-xs">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    <tr data-id="{{$user['role_id']}}">
                        <td></td>
                        <td><input type="text" name="user_id" class="form-control"></td>
                        <td>{{$user['role_id']}}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('.form-control').blur(function () {
            var id = $(this).parent().parent().attr('data-id');
            var user_id = $(this).val();

            var url = '{{url('/Auth.roleBindUser')}}';
            var data = {
                '_token': '{{csrf_token()}}',
                'role_id': id,
                'user_id': user_id,
                'command': 'add',
            };
            jinono.requestEvent.apply(url, data);
        });

        $('.btn').click(function () {
            var id = $(this).parent().parent().attr('data-id');
            var user_id = $(this).attr('data-usr');
            var url = '{{url('/Auth.roleBindUser')}}';
            var data = {
                '_token': '{{csrf_token()}}',
                'role_id': id,
                'user_id': user_id,
                'command': 'del',
            }
            jinono.requestEvent.apply(url, data);
        });
    </script>
@stop