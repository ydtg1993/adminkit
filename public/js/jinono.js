(function (window) {

    'use strict';

    var jinono = {
        base_url: 'http://' + window.location.host,
        now_time: function () {
            return (Date.parse(new Date()) / 1000);
        },
        prompt: function () {

        },
        redirect:{
            init:function () {
                $('.redirect_button').click(jinono.redirect.apply);
            },
            apply:function () {
                window.location.href = $(this).attr('data-href');
            }
        },
        requestEvent: {
            apply: function (url, data, method, callback) {
                method = typeof method !== 'undefined' ? method : 'POST';
                callback = typeof callback == 'function' ? callback : function (d) {
                };
                data._token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    dataType: 'json',
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
            url: '',
            redirect: '',
            data: {},
            sub_flag: false,
            init: function (url, redirect) {
                jinono.login.url = url;
                jinono.login.redirect = redirect;
                $('#login input').change(jinono.login.change_event);
                $('#login #submit').click(jinono.login.submit_event);
            },
            change_event: function () {
                var name = $(this).prop('name');
                var val = $(this).val();
                jinono.login.data[name] = val;

                if ($(this).val()) {
                    $(this).parent().addClass('input--filled');
                    return;
                }
                $(this).parent().removeClass('input--filled');
            },
            submit_event: function () {
                if (jinono.login.sub_flag) {
                    return;
                }
                jinono.login.sub_flag = true;

                jinono.requestEvent.apply(jinono.login.url, jinono.login.data, 'POST', function (d) {
                    jinono.login.sub_flag = false;
                    if (d.code == 0) {
                        window.location.href = jinono.login.redirect;
                        return;
                    }
                    $('#login .password_message').text('密码错误');
                });
            }
        },
        navigation: {
            dom: null,
            but: null,
            init: function () {
                jinono.navigation.dom = $('#navigation');
                jinono.navigation.but = $('#navigation_open');

                jinono.navigation.memory();

                $('#container').click(jinono.navigation.close);
                $('#navigation_close').click(jinono.navigation.close);
                $('#navigation_open').click(jinono.navigation.open);
                jinono.navigation.listener();
            },
            memory: function () {
                var navigation = localStorage.getItem("navigation");
                if (navigation == 1) {
                    jinono.navigation.dom.css('display', 'block');
                    jinono.navigation.dom.removeClass('uk-animation-reverse').addClass('uk-animation-slide-left-medium');
                    localStorage.setItem("navigation", 1);
                } else {
                    jinono.navigation.dom.css('display', 'none');
                }
            },
            close: function () {
                var navigation = localStorage.getItem("navigation");
                if (navigation == 0) {
                    return;
                }
                jinono.navigation.dom.addClass('uk-animation-slide-left-medium uk-animation-reverse');
                localStorage.setItem("navigation", 0);
            },
            open: function () {
                var navigation = localStorage.getItem("navigation");
                if (navigation == 1) {
                    return;
                }
                jinono.navigation.dom.css('display', 'block');
                jinono.navigation.dom.removeClass('uk-animation-reverse').addClass('uk-animation-slide-left-medium');
                localStorage.setItem("navigation", 1);
            },
            listener: function () {
                document.querySelector('#navigation').addEventListener("webkitAnimationEnd", function () {
                    var navigation = localStorage.getItem("navigation");
                    if (navigation == 1) {
                        jinono.navigation.dom.removeClass('uk-animation-slide-left-medium');
                        jinono.navigation.but.css('display', 'none');
                    } else {
                        jinono.navigation.dom.css('display', 'none');
                        jinono.navigation.but.css('display', 'block');
                        jinono.navigation.but.addClass('uk-animation-fade');
                    }
                });
            }
        },
        auto_input_update: {
            url: '',
            is_up: false,
            flag: false,
            data: {},
            init: function (url, data,callback) {
                jinono.auto_input_update.url = url;
                data = typeof data == 'object' ? data : {};
                callback = typeof callback == 'function' ? callback : function () {
                };
                jinono.auto_input_update.data = data;
                callback();

                var dom = $('.auto_input_update input');
                dom.focus(function () {
                    jinono.auto_input_update.is_up = false;
                });
                dom.change(function () {
                    jinono.auto_input_update.is_up = true;
                });
                dom.blur(jinono.auto_input_update.apply);
            },
            apply: function () {
                if (jinono.auto_input_update.flag) {
                    return;
                }
                if (jinono.auto_input_update.is_up == false) {
                    return;
                }

                jinono.auto_input_update.data['id'] = parseInt($(this).attr('data-id'));
                var name = $(this).prop('name');
                jinono.auto_input_update.data[name] = $(this).val();

                jinono.auto_input_update.flag = true;
                jinono.requestEvent.apply(jinono.auto_input_update.url, jinono.auto_input_update.data, 'POST', function (d) {
                    jinono.auto_input_update.flag = false;
                    if (d.code == 0) {
                        return;
                    }
                });
            }
        },
        auto_radio_select: {
            url: '',
            flag: false,
            data: {},
            init: function (url, data) {
                jinono.auto_radio_select.url = url;
                data = typeof data == 'object' ? data : {};
                jinono.auto_radio_select.data = data;
                $('.auto_radio_select input').click(jinono.auto_radio_select.apply);
            },
            apply: function () {
                if (jinono.auto_radio_select.flag) {
                    return;
                }
                jinono.auto_radio_select.flag = true;

                jinono.auto_radio_select.data['id'] = parseInt($(this).attr('data-id'));
                jinono.auto_radio_select.data['select'] = parseInt($(this).val());

                jinono.requestEvent.apply(jinono.auto_radio_select.url, jinono.auto_radio_select.data, 'POST', function (d) {
                    jinono.auto_radio_select.flag = false;
                    if (d.code == 0) {
                        return;
                    }
                });
            }
        },
        input_update: {
            url: '',
            is_up: false,
            flag: false,
            data: {},
            init: function (url, data,callback) {
                jinono.input_update.url = url;
                data = typeof data == 'object' ? data : {};
                callback = typeof callback == 'function' ? callback : function () {
                };
                jinono.input_update.data = data;
                callback();

                var dom = $('.input_update input');
                dom.focus(function () {
                    jinono.input_update.is_up = false;
                });
                dom.change(function () {
                    jinono.input_update.is_up = true;
                });
                dom.blur(jinono.input_update.apply);

                $('.input_update .commit').click(jinono.input_update.commit)
            },
            apply: function () {
                if (jinono.input_update.is_up == false) {
                    return;
                }

                var name = $(this).prop('name');
                jinono.input_update.data[name] = $(this).val();
            },
            commit:function () {
                if (jinono.input_update.flag) {
                    return;
                }
                jinono.input_update.flag = true;
                jinono.requestEvent.apply(jinono.input_update.url, jinono.input_update.data, 'POST', function (d) {
                    jinono.input_update.flag = false;
                    if (d.code == 0) {
                        return;
                    }
                });
            }
        }
    };

    if (typeof define === 'function' && define.amd) {
        // AMD
        define(jinono);
    } else {
        window.jinono = jinono;
    }
})(window);