<nav class="fixed-sidebar-left left-width">
    <ul class="side-nav nicescroll-bar">
        <li class="navigation-header"><span>default</span><i class="icon-dots-three-horizontal"></i></li>
        <li>
            <a class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                <div class="float-left"><i class="icon-home3"></i><span class="right-nav-text">@lang('administrator.sidebar.home')</span></div>
                <div class="clearfix"></div>
            </a>
        </li>

        <li><hr class="mb-0"></li>
        <li class="navigation-header"><span>system</span><i class="icon-dots-three-horizontal"></i></li>
        <li>
            <a class="collapsed {{ isset($pageData->parent) && ($pageData->parent === 'menu-control') ? 'active' : '' }}"
               href="javascript:void(0);"
               data-toggle="collapse"
               data-target="#Menu_dr2_1">
                <div class="float-left"><i class="icon-folder"></i><span class="right-nav-text">系統選單管理</span></div>
                <div class="float-right"><i class="icon-chevron-small-right"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul class="collapse collapse-level-1 {{ isset($pageData->parent) && ($pageData->parent === 'menu-control') ? 'show' : '' }}" id="Menu_dr2_1">
                <li><a class="{{ isset($pageData->uri) && $pageData->uri === 'admin-menu-class' ? 'active' : '' }}" href="{{ url('administrator/admin-menu-class') }}">管理員選單類別</a></li>
                <li><a class="{{ isset($pageData->uri) && $pageData->uri === 'admin-menu-item' ? 'active' : '' }}" href="{{ url('administrator/admin-menu-item') }}">管理員選單目錄</a></li>
                <li><a class="{{ isset($pageData->uri) && $pageData->uri === 'merchant-menu-class' ? 'active' : '' }}" href="{{ url('administrator/merchant-menu-class') }}">經銷商選單類別</a></li>
                <li><a class="{{ isset($pageData->uri) && $pageData->uri === 'merchant-menu-item' ? 'active' : '' }}" href="{{ url('administrator/merchant-menu-item') }}">經銷商選單目錄</a></li>
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