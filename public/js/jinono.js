( function( window ) {

    'use strict';

    var jinono = {
        base_url:'http://'+window.location.host,
        now_time:function () {
            return (Date.parse(new Date()) / 1000);
        },
        requestEvent: {
            apply: function (url,data,method,callback) {
                method = typeof method !== 'undefined' ?  method : 'POST';
                callback = typeof callback == 'function' ?  callback : function (d) {};
                data._token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    dataType : 'json',
                    type: method,
                    url: url,
                    data: data,
                    success: function (d) {
                        callback(d);
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

                jinono.requestEvent.apply(jinono.login.url,jinono.login.data,'POST',function (d) {
                    jinono.login.sub_flag = false;
                    if(d.code == 0){
                        window.location.href = jinono.login.redirect;
                        return;
                    }
                    $('#login .password_message').text('密码错误');
                });
            }
        },
        navigation:{
            dom:null,
            but:null,
            init:function () {
                jinono.navigation.dom = $('#navigation');
                jinono.navigation.but = $('#navigation_open');
                var navigation = localStorage.getItem("navigation");
                if(navigation == 1){
                    jinono.navigation.open();
                }else {
                    jinono.navigation.dom.css('display','none');
                }
                $('#container').click(jinono.navigation.close);
                $('#navigation_close').click(jinono.navigation.close);
                $('#navigation_open').click(jinono.navigation.open);
            },
            close:function () {
                var navigation = localStorage.getItem("navigation");
                if(navigation == 0){
                    return;
                }
                jinono.navigation.dom.addClass('uk-animation-slide-left-medium uk-animation-reverse');
                localStorage.setItem("navigation",0);
                jinono.navigation.end();
            },
            open:function () {
                var navigation = localStorage.getItem("navigation");
                if(navigation == 1){
                    return;
                }
                jinono.navigation.dom.css('display','block');
                jinono.navigation.dom.removeClass('uk-animation-reverse').addClass('uk-animation-slide-left-medium');
                localStorage.setItem("navigation",1);
                jinono.navigation.end();
            },
            end:function () {
                document.querySelector('#navigation').addEventListener("webkitAnimationEnd", function() {
                    var navigation = localStorage.getItem("navigation");
                    if(navigation == 1){
                        jinono.navigation.dom.removeClass('uk-animation-slide-left-medium');
                        jinono.navigation.but.css('display','none');
                    }else {
                        jinono.navigation.dom.css('display','none');
                        jinono.navigation.but.css('display','block');
                        jinono.navigation.but.addClass('uk-animation-fade');
                    }
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