function Site(object) {
    this.userInfo = object.USER;
    this.baseUrl = object.ROOT;
}


Site.prototype = {
    /**
     * 获取网站url
     *
     * @param {string} [path]
     * @returns {string}
     */
    url: function (path) {
        return this.baseUrl + (path ? '/' + path : '');
    },

    /**
     * 是否已经登录
     *
     * @returns {boolean}
     */
    isLogin: function () {
        return !$.isEmptyObject(this.userInfo);
    },

    /**
     * 判断是否使用手机浏览器
     *
     * @returns {boolean}
     */
    inMobile: function () {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    },

    /**
     * 获取登录用户信息
     *
     * @param {string} [key]
     * @returns {*}
     */
    user: function (key) {
        if (typeof key == 'undefined') {
            return this.userInfo;
        }

        return this.userInfo && this.userInfo[key];
    },

    /**
     * 刷新页面
     *
     * @param {boolean} [force]
     */
    refresh: function (force) {
        window.top.location.reload(force);
    },

    /**
     * 重定向到某个页面
     *
     * @param {string} [path]
     */
    redirect: function (path) {
        window.location.href = this.url(path);
    },


    /**
     * 重定向到上一页面
     *
     * @param {string} [defaultPath]
     */
    redirectReferer: function (defaultPath) {
        var referer = window.document.referrer;

        if (!referer && typeof defaultPath === 'undefined') {
            this.refresh(true);
        } else {
            var url = referer ? referer : this.url(defaultPath);
            window.location.href = url;
        }
    }
};

/**
 * 实例化全局对象
 */
var site = new Site(SITE);

$(function () {
    /**
     * 通用jquery扩展方法
     */

    // 设置全局 xsrf-token
    jQuery.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN'),
        },
        error: function (jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case(500):
                    layer.msg("服务器系统错误");
                    break;
                case(401):
                    site.redirect('auth/login');
                    break;
                case(403):
                    layer.msg("无权限执行此操作");
                    break;
                case(408):
                    layer.msg("请求超时");
                    break;
                case(422):
                    layer.msg(jqXHR.responseJSON.message[0], function () {
                    });
                    break;
                case(400):
                    layer.msg(jqXHR.responseJSON.message, function () {
                    });
                    break;
                default:
                    layer.msg("未知错误");
            }
        }
    });

    var commonAjaxSetup = function () {
        // 通用异步表单提交
        $(document.body).on('click', 'form.ajax-form [type="submit"]', function () {
            var self = $(this)
                , form = self.closest('form') ? self.closest('form') : $([])
                , method = self.data('method') || form.attr('method')
                , url = self.data('url') || form.attr('action')
                , buttonHtml = self.html() || '提交'
                , data = form.serializeArray()
                , delay = self.data('delay') || form.data('delay') || 2000
                , doneThen = self.data('doneThen') || form.data('doneThen')
                , doneUrl = self.data('doneUrl') || form.data('doneUrl')
                , danger = self.data('danger') || form.data('danger')

            $.each(self.data('data') || {}, function (name, value) {
                data.push({name: name, value: value})
            });

            $.ajax({url: url, method: method, data: data}).done(function (res) {
                alert();
            })

        }).on('submit', 'form.ajax-form', function (e) {
            // 表单提交
            e.preventDefault();
            return false;
        })
    };
    /**
     * 初始化方法
     */
    jQuery(function () {
        // 通用ajax设置
        commonAjaxSetup();
    });
});

/**
 * get提交form处理
 * @param exceptName
 */
var formSubmitByGet = function (exceptName) {
    exceptName = exceptName || [];
    $('.search-by-get').on('click', function () {
        var obj = $(this), form = obj.closest('form'), query = new Array(), action = form.attr('action');
        $.each(form.serializeArray(), function (i, o) {
            if (o.value && $.inArray(o.name, exceptName) == -1) {
                query.push(o.name + '=' + o.value);
            }
        });
        var povit = action.indexOf('?') >= 0 ? '&' : '?', queryString = query.length ? povit + query.join('&') : '';
        window.location.href = (queryString) ? action + queryString : action;
        return false;
    })
};

function dd(par) {
    console.log(par);
}