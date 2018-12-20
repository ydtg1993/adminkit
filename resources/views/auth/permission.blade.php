@extends('layouts.master')

@section('title', 'jinono')

@section('container')

    <div style="padding: 10px">
        <h3>{{$role['name']}}</h3>
        @foreach($permissions as $controller =>$permission)
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{$controller}}</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                @foreach($permission as $p)
                                    <div class="btn btn-default btn-flat">
                                        <input type="checkbox" data-permission-id="{{$p['id']}}" class="checkbox-inline"
                                               @if($p['isset'])checked="checked"@endif>
                                        {{$p['slug']}}
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        $('input').click(function () {
            var is_check = $(this).prop("checked");
            var command = 'del';
            if (is_check) {
                command = 'add';
            }
            var url = '{{url('/Auth.permission')}}';
            var role_id = '{{$role['id']}}';
            var permission_id = $(this).attr('data-permission-id');
            var data = {role_id: role_id, permission_id: permission_id, command: command, '_token': '{{csrf_token()}}'};
            jinono.requestEvent.apply(url, data);
        });
    </script>
@stop