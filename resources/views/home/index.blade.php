@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
            <article class="markdown-body entry-content" itemprop="text">
                <h3 align="center"><a id="user-content-后台管理系统雏形" class="anchor" aria-hidden="true" href="https://github.com/ydtg1993/admin">
                        <svg class="octicon octicon-link" viewBox="0 0 16 16" version="1.1" width="16" height="16"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M4 9h1v1H4c-1.5 0-3-1.69-3-3.5S2.55 3 4 3h4c1.45 0 3 1.69 3 3.5 0 1.41-.91 2.72-2 3.25V8.59c.58-.45 1-1.27 1-2.09C10 5.22 8.98 4 8 4H4c-.98 0-2 1.22-2 2.5S3 9 4 9zm9-3h-1v1h1c1 0 2 1.22 2 2.5S13.98 12 13 12H9c-.98 0-2-1.22-2-2.5 0-.83.42-1.64 1-2.09V6.25c-1.09.53-2 1.84-2 3.25C6 11.31 7.55 13 9 13h4c1.45 0 3-1.69 3-3.5S14.5 6 13 6z"></path>
                        </svg>
                    </a>后台管理系统雏形
                </h3>
                <pre><code>  laravel和Uikit开发的后台管理系统模型 欢迎使用
</code></pre>
                <p align="left">
                    <a href="https://laravel.com" rel="nofollow"><img
                                src="https://camo.githubusercontent.com/527a7a28f8b88fabcd87155b07ee07c2c379bd05/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6c61726176656c2d68747470732533412532462532466c61726176656c2e636f6d2532462d7265642e737667"
                                alt="Build Status"
                                data-canonical-src="https://img.shields.io/badge/laravel-https%3A%2F%2Flaravel.com%2F-red.svg"
                                style="max-width:100%;"></a>
                    <a href="https://getuikit.com" rel="nofollow"><img
                                src="https://camo.githubusercontent.com/1725e470f45f8cfd15630983387e5099885ac6a3/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f55496b69742d687474707325334125324625324667657475696b69742e636f6d2532462d626c75652e737667"
                                alt="Total Downloads"
                                data-canonical-src="https://img.shields.io/badge/UIkit-https%3A%2F%2Fgetuikit.com%2F-blue.svg"
                                style="max-width:100%;"></a>
                </p>
                <h2>说明事项
                </h2>
                <ol>
                    <li>
                        <p>请star并关注 <a href="https://github.com/ydtg1993/admin.git">admin</a> 提出您宝贵的意见 :-)</p>
                    </li>
                    <li>
                        <p>打开导航菜单栏程序会自动获取controller目录下的类文件方法 根据所需配置路由添加菜单栏选项</p>
                    </li>
                    <li>
                        <p>信息输入框的内容均采用blur离焦事件自动保存修改 (增添信息输入框需点击 "保存信息" 手动提交)</p>
                    </li>
                </ol>
            </article>
        </div>
    </div>

@stop