<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">玩转互娱</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">玩转互娱</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="javascript:;" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="javascript:;" data-toggle="modal" data-target="#modal-change-password">修改密码</a>
                </li>
                <li>
                    <a href="#">退出登录</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="modal fade in" id="modal-change-password" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="padding-top:0;">帐号名</label>
                            <div class="col-sm-10">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">旧密码</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="旧密码" type="password" id="old-password">
                                <span class="help-block" style="display: none;">请输入旧密码</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">新密码</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="新密码" type="password" id="new-password">
                                <span class="help-block" style="display: none;">请输入新密码</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">确认密码</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="确认密码" type="password" id="re-password">
                                <span class="help-block" style="display: none;">请输入正确的新密码</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="change_password_submit">确认修改</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#change_password_submit').click(function () {
        $('#old-password').siblings('span').hide().closest('.form-group').removeClass('has-error');
        $('#new-password').siblings('span').hide().closest('.form-group').removeClass('has-error');
        $('#re-password').siblings('span').hide().closest('.form-group').removeClass('has-error');
        var old_password = $('#old-password').val();
        var new_password = $('#new-password').val();
        var re_password = $('#re-password').val();

        if (old_password == '') {
            $('#old-password').siblings('span').show().closest('.form-group').addClass('has-error');
            return;
        }
        if (new_password == '') {
            $('#new-password').siblings('span').show().closest('.form-group').addClass('has-error');
            return;
        }
        if (new_password != re_password) {
            $('#re-password').siblings('span').show().closest('.form-group').addClass('has-error');
            return;
        }

        $.post('/api/user/changeSelfPassword', {
            old_password: old_password,
            new_password: new_password
        }, function (res) {
            if (res && res.code == 0) {
                $('#modal-change-password').modal('hide');
                layer.msg('修改成功')
            } else {
                layer.msg('修改失败',function () {})
            }
        });
    });
</script>
