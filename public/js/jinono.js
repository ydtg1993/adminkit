( function( window ) {

    'use strict';

    var jinono = {
        base_url:'http://'+window.location.host,
        time:function () {
            return (Date.parse(new Date()) / 1000);
        },
        requestEvent: {
            apply: function (url,data,method,refresh,callback) {
                method = typeof method !== 'undefined' ?  method : 'POST';
                refresh = typeof refresh !== 'undefined' ?  refresh : true;
                callback = typeof callback == 'function' ?  callback : function (d) {};
                data._token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    dataType : 'json',
                    type: method,
                    url: url,
                    data: data,
                    success: function (d) {
                        if (d.code == 0) {
                            if(refresh) {
                                callback(d);
                                window.location.reload();
                                return;
                            }
                            callback(d);
                            return;
                        }
                        callback(d);
                        return;
                    }
                });
            }
        },
        login: {
            url:'',
            redirect:'',
            data:{},
            sub_flag:false,
            init:function (url,redirect) {
                jinono.login.url = url;
                jinono.login.redirect = redirect;
                $('#login input').change(jinono.login.change_event);
                $('#login #submit').click(jinono.login.submit_event);
            },
            change_event:function () {
                var name = $(this).prop('name');
                var val = $(this).val();
                jinono.login.data[name] = val;

                if($(this).val()){
                    $(this).parent().addClass('input--filled');
                    return;
                }
                $(this).parent().removeClass('input--filled');
            },
            submit_event:function () {
                if(jinono.login.sub_flag){
                    return;
                }
                jinono.login.sub_flag = true;

                jinono.requestEvent.apply(jinono.login.url,jinono.login.data,'POST',false,function (d) {
                    jinono.login.sub_flag = false;
                    if(d.code == 0){
                        window.location.href = jinono.login.redirect;
                        return;
                    }
                    $('#login .password_message').text('密码错误');
                });
            }
        }
    };

    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( jinono );
    } else {
        window.jinono = jinono;
    }
})( window );