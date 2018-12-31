@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <h3>{{$role['name']}}</h3>
    @foreach($permissions as $controller =>$permission)
        <div>
            <div class="uk-card uk-card-default uk-card-hover uk-card-body" style="padding: 10px 40px">
                <h3 class="uk-card-title">{{$controller}}</h3>
                <p>
                    <div class="auto_radio_select" class="uk-child-width-1-6 uk-grid-small uk-grid-match" uk-grid>
                        @foreach($permission as $p)
                            <div>
                                <div class="uk-card uk-card-primary uk-card-body uk-card-hover" style="padding: 10px 40px;">
                                    <h3 class="uk-card-title">{{$p['action'] ? $p['action'] : '全选'}}</h3>
                                    <p>
                                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                            <label>
                                                <input class="uk-radio" data-v={"id":{{$p['id']}}} type="radio" name="{{$controller.'@'.$p['action']}}" value="1" @if($p['isset'] == 1)checked="checked"@endif>
                                                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> 开</font></font>
                                            </label>
                                            <label>
                                                <input class="uk-radio" data-v={"id":{{$p['id']}}} type="radio" name="{{$controller.'@'.$p['action']}}" value="0" @if($p['isset'] == 0)checked="checked"@endif>
                                                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> 关</font></font>
                                            </label>
                                        </div>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </p>
            </div>
        </div>
    @endforeach

    <script>
        $(function () {
           jinono.auto_radio_select.init('{{url('Auth.permission')}}',{role_id:'{{$role['id']}}'});
        });
    </script>
@stop