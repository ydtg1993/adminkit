@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    @foreach($list as $class_name=>$data)
        <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body" style="padding: 0 40px">
            <h3 class="uk-card-title">{{$class_name}}</h3>
            <p>
            <table class="uk-table uk-table-striped" id="auto_input_update">
                <thead>
                <tr>
                    <th>id</th>
                    <th>p_id</th>
                    <th>控制器</th>
                    <th>方法</th>
                    <th>菜单名</th>
                    <th>可见</th>
                    <th>排序</th>
                    <th>描述</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr class="auto_input_update">
                        <td>{{$d['id']}}</td>
                        <td>{{$d['p_id']}}</td>
                        <td>{{$d['controller']}}</td>
                        <td>{{$d['action']}}</td>
                        <td style="width: 120px">
                            <div class="uk-margin">
                                <input data-id="{{$d['id']}}" name="name" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" value="{{$d['name']}}" />
                            </div>
                        </td>
                        <td style="width: 120px">
                            <div class="uk-margin">
                                <input data-id="{{$d['id']}}" name="view" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" value="{{$d['view']}}" />
                            </div>
                        </td>
                        <td style="width: 120px">
                            <div class="uk-margin">
                                <input data-id="{{$d['id']}}" name="sort" style="width: 120px" class="uk-input uk-form-width-medium uk-form-small" value="{{$d['sort']}}" />
                            </div>
                        </td>
                        <td>{{$d['description']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </p>
        </div>
        </div>
    @endforeach

    <script>
        $(function () {
           jinono.auto_input_update.init('{{url('Auth.upMenu')}}');
        });
    </script>
@stop