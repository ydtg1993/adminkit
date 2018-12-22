@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    @foreach($list as $class_name=>$data)
        <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
            <h3 class="uk-card-title">{{$class_name}}</h3>
            <p>
            <table class="uk-table uk-table-striped">
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
                    <tr>
                        <td>{{$d['id']}}</td>
                        <td>{{$d['p_id']}}</td>
                        <td>{{$d['controller']}}</td>
                        <td>{{$d['action']}}</td>
                        <td width="120px"><input name="name" class="input" value="{{$d['name']}}" /></td>
                        <td width="120px"><input name="view" class="input" value="{{$d['view']}}" /></td>
                        <td width="120px"><input name="sort" class="input" value="{{$d['sort']}}"></td>
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

    </script>
@stop