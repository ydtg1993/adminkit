@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">

            {!! $tree_view !!}

        </div>
    </div>
    <script>
        jinono.tree_view.init();
    </script>
@stop