<nav class="fixed-sidebar-left left-width">
    <ul class="side-nav nicescroll-bar">
        <li class="navigation-header"><span>default</span><i class="icon-dots-three-horizontal"></i></li>
        <li>
            <a class="{{ Route::currentRouteName() === 'admin.home' ? 'active' : '' }}" href="{{ route('admin.home') }}">
                <div class="float-left"><i class="icon-home3"></i><span class="right-nav-text">@lang('admin.sidebar.home')</span></div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li><hr class="mb-0"></li>
        <li class="navigation-header"><span>system</span><i class="icon-dots-three-horizontal"></i></li>
        <li>
            <a class="collapsed {{ isset($pageData->parent) && ($pageData->parent === 'permission-control') ? 'active' : '' }}"
               href="javascript:void(0);"
               data-toggle="collapse"
               data-target="#Menu_dr2_1">
                <div class="float-left"><i class="icon-group"></i><span class="right-nav-text">權限管理</span></div>
                <div class="float-right"><i class="icon-chevron-small-right"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul class="collapse collapse-level-1 {{ isset($pageData->parent) && ($pageData->parent === 'permission-control') ? 'show' : '' }}" id="Menu_dr2_1">
                <li><a class="{{ isset($pageData->uri) && $pageData->uri === 'role' ? 'active' : '' }}" href="{{ url('administrator/role') }}">權限角色管理</a></li>
            </ul>
        </li>
        <li>
            <a class="{{ isset($pageData->uri) && $pageData->uri === 'language' ? 'active' : '' }}" href="{{ url('administrator/language') }}">
                <div class="float-left"><i class="icon-globe"></i><span class="right-nav-text">語系管理</span></div>
                <div class="clearfix"></div>
            </a>
        </li>
        <li>
            <a class="{{ isset($pageData->uri) && $pageData->uri === 'web-data' ? 'active' : '' }}" href="{{ url('administrator/web-data') }}">
                <div class="float-left"><i class="icon-cog"></i><span class="right-nav-text">網站基本資訊</span></div>
                <div class="clearfix"></div>
            </a>
        </li>
        <li>
            <a class="{{ isset($pageData->uri) && $pageData->uri === 'system-log' ? 'active' : '' }}" href="{{ url('administrator/system-log') }}">
                <div class="float-left"><i class="icon-warning"></i><span class="right-nav-text">操作紀錄</span></div>
                <div class="clearfix"></div>
            </a>
        </li>
    </ul>
</nav>