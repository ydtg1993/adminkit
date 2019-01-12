@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">

            {!! $tree_view !!}

        </div>
    </div>

    <div id="modal-overflow" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Headline</h2>
            </div>
            <div class="uk-modal-body">
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-danger" type="button">删除</button>
            </div>
        </div>
    </div>

    <script>
        jinono.tree_view.init();
    </script>
@stop