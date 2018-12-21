@extends('layouts/common')

@section('title', 'jinono')

@section('content')

        <div class="box">
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>id</th>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{$role['id']}}</td>
                        <td>{{$role['name']}}</td>
                        <td>
                            <a href="{{url(ADMIN_URI.'/Auth.roleBindUser/'.$role['id'])}}" type="button" class="btn btn-default btn-xs">绑定用户</a>
                            <a href="{{url(ADMIN_URI.'/Auth.permission/'.$role['id'])}}" type="button" class="btn btn-default btn-xs">权限设置</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td><input type="text" name="name" class="form-control"></td>
                        <td>
                            <a href="" type="button" class="btn btn-default btn-xs">删除</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

@stop