( function( window ) {

    'use strict';

    var jinono = {
        base_url:'http://'+window.location.host,
        now_time:function () {
            return (Date.parse(new Date()) / 1000);
        },
        prompt:function () {

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

                jinono.navigation.memory();

                $('#container').click(jinono.navigation.close);
                $('#navigation_close').click(jinono.navigation.close);
                $('#navigation_open').click(jinono.navigation.open);
                jinono.navigation.listener();
            },
            memory:function () {
                var navigation = localStorage.getItem("navigation");
                if(navigation == 1){
                    jinono.navigation.dom.css('display','block');
                    jinono.navigation.dom.removeClass('uk-animation-reverse').addClass('uk-animation-slide-left-medium');
                    localStorage.setItem("navigation",1);
                }else {
                    jinono.navigation.dom.css('display','none');
                }
            },
            close:function () {
                var navigation = localStorage.getItem("navigation");
                if(navigation == 0){
                    return;
                }
                jinono.navigation.dom.addClass('uk-animation-slide-left-medium uk-animation-reverse');
                localStorage.setItem("navigation",0);
            },
            open:function () {
                var navigation = localStorage.getItem("navigation");
                if(navigation == 1){
                    return;
                }
                jinono.navigation.dom.css('display','block');
                jinono.navigation.dom.removeClass('uk-animation-reverse').addClass('uk-animation-slide-left-medium');
                localStorage.setItem("navigation",1);
            },
            listener:function () {
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
        },
        auto_form:{
            url:'',
            is_up:false,
            flag:false,
            init:function (url) {
                jinono.auto_form.url = url;
                var dom = $('#auto-form input');
                dom.focus(function () {
                    jinono.auto_form.is_up = false;
                });
                dom.change(function () {
                    jinono.auto_form.is_up = true;
                });
                dom.blur(jinono.auto_form.apply);
            },
            apply:function () {
                if(jinono.auto_form.flag){
                    return;
                }
                if(jinono.auto_form.is_up == false){
                    return;
                }
                var data = {
                    'id':parseInt($(this).attr('data-id'))
                };
                var name = $(this).prop('name');
                data[name] = $(this).val();

                jinono.auto_form.flag = true;
                jinono.requestEvent.apply(jinono.auto_form.url,data,'POST',function (d) {
                    jinono.auto_form.flag = false;
                    if(d.code == 0){
                        return;
                    }
                });
            }
        },
        auto_radio:{
            url:'',
            flag:false,
            data:{},
            init:function (url,data) {
                jinono.auto_radio.url = url;
                data = typeof data == 'object' ?  data : {};
                jinono.auto_radio.data = data;
                $('#auto_radio input').click(jinono.auto_radio.apply);
            },
            apply:function () {
                if(jinono.auto_radio.flag){
                    return;
                }
                jinono.auto_radio.flag = true;

                jinono.auto_radio.data['id'] = parseInt($(this).attr('data-id'));
                jinono.auto_radio.data['select'] = parseInt($(this).val());

                jinono.requestEvent.apply(jinono.auto_radio.url,jinono.auto_radio.data,'POST',function (d) {
                    jinono.auto_radio.flag = false;
                    if(d.code == 0){
                        return;
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