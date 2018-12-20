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
            data:{},
            sms_flag:false,
            sub_flag:false,
            init:function () {
                $('#login input').change(this.change_event);
                $('#login .get_sms').click(this.sms_event);
                $('#login #submit').click(this.sub_event);
            },
            change_event:function () {
                var name = $(this).prop('name');
                var val = $(this).val();
                jinono.login.data[name] = val;
            },
            sub_event:function () {
                jinono.requestEvent.apply(jinono.base_url+'/login',jinono.login.data,'POST',false,function (d) {
                    if(d.code == 0){
                        layer.msg('登录成功', {
                            time: 1000,
                            end: function () {
                                location.href = jinono.base_url;
                            }
                        });
                        return;
                    }
                    layer.msg('登录失败', {
                        time: 1000,
                        end: function () {

                        }
                    });
                });
            }
        },
        form:{
            url:'',
            data:{},
            init:function (url) {
                jinono.form.url = url;
                $('#form input').blur(this.change_event);
                $('#form #submit').click(this.sub_event);
            },
            change_event:function () {
                var name = $(this).prop('name');
                var val = $(this).val();
                jinono.login.data[name] = val;
            },
            sub_event:function () {
                jinono.requestEvent.apply(jinono.form.url,jinono.login.data,'POST',false,function (d) {
                    if(d.code == 0){
                        layer.msg('操作成功', {
                            time: 1000,
                            end: function () {
                                location.href = jinono.base_url;
                            }
                        });
                        return;
                    }
                    layer.msg('操作失败', {
                        time: 1000,
                        end: function () {

                        }
                    });
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