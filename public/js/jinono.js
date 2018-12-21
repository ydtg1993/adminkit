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
                            alert(d.msg);
                            return;
                        }
                        callback(d);
                        alert(d.msg);
                        return;
                    }
                });
            }
        },
        login: {
            sms_flag:false,
            sub_flag:false,
            init:function () {
                $('#login input').change(this.change_event);
                $('#login .get_sms').click(this.sms_event);
                $('#login #submit').click(this.sub_event);
            },
            change_event:function () {
                $('#login .mobile_message').text('');
                if($(this).val()){
                    $(this).parent().addClass('input--filled');
                    return;
                }
                $(this).parent().removeClass('input--filled');
            },
            sms_event:function () {
                var mobile = $('input[name="mobile"]').val();
                if(!mobile){
                    $('#login .mobile_message').text('请输入手机号');
                    return;
                }
                if(!(/^1[34578]\d{9}$/.test(mobile))){
                    $('#login .mobile_message').text('手机号错误');
                    return;
                }
                var sms_ttl = parseInt(localStorage.getItem('sms_ttl'));
                var now = jinono.time();
                if(now < sms_ttl){
                    $('#login .code_message').text('短信已发送');
                    return;
                }
                localStorage.setItem('sms_ttl',now + 180);

                if(!jinono.login.sms_flag){
                    jinono.login.sms_flag = true;
                    var url = jinono.base_url+'/passport';

                    jinono.requestEvent.apply(url,{mobile:mobile},'POST',false,function (d) {
                        jinono.login.sms_flag = false;
                    });
                }
            },
            sub_event:function () {

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