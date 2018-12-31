@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <h3>{{$role['name']}}</h3>
    @foreach($permissions as $controller =>$permission)
        <div>
            <div class="uk-card uk-card-default uk-card-hover uk-card-body" style="padding: 10px 40px">
                <h3 class="uk-card-title">{{$controller}}</h3>
                <p>
                    <div class="uk-child-width-1-6 uk-grid-small uk-grid-match" uk-grid>
                        <div class="auto_check">
                            <div class="uk-card uk-card-secondary uk-card-body uk-card-hover" style="padding: 10px 40px;">
                                <h3 class="uk-card-title">全选</h3>
                             <p>
                                <label>
                                    <input data-v={"controller":"{{$controller}}"} data-k="checked" name="view"
                                           class="uk-checkbox" @if($permissions[$controller]['all'] == 1)checked="checked"@endif
                                           type="checkbox">
                                    开启
                                </label>
                            </p>
                        </div>
                    </div>

                        @foreach($permission as $k=>$p)
                            @if($k == 'all')
                                @continue
                            @endif
                            <div class="auto_radio_select">
                                <div class="uk-card uk-card-primary uk-card-body uk-card-hover" style="padding: 10px 40px;">
                                    <h3 class="uk-card-title">{{$p['action'] ? $p['action'] : $p['controller']}}</h3>
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
           jinono.auto_check.init('{{url('Auth.permission')}}',{role_id:'{{$role['id']}}'});
        });
    </script>
@stop