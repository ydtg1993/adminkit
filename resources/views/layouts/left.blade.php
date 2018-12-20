<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            @foreach($navigation as $navs)
                @if(sizeof($navs) > 1)
                    <li class="treeview">
                        <a href="#"><i class="fa fa-link"></i> <span>{{current($navs)['c_name']}}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                        </a>
                        <ul class="treeview-menu">
                            @foreach($navs as $nav)
                                <li><a href="{{url('/'.$nav['slug'])}}">{{$nav['m_name']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li @if($slug == current($navs)['slug'])
                        class="active"
                            @endif
                    ><a href="{{url('/'.current($navs)['slug'])}}"><i class="fa fa-link"></i> <span>{{current($navs)['m_name']}}</span></a></li>
                @endif
            @endforeach
        </ul>

    </section>

</aside>