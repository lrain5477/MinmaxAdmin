<?php
/**
 * @var \Illuminate\Support\Collection $menuData (Items are model App)
**/
?>
<nav class="fixed-sidebar-left left-width">
    <ul class="side-nav nicescroll-bar">
        <li class="navigation-header"><span>default</span><i class="icon-dots-three-horizontal"></i></li>
        <li>
            <a class="{{ Route::currentRouteName() === 'admin.home' ? 'active' : '' }}" href="{{ route('admin.home') }}">
                <div class="float-left"><i class="icon-home3"></i><span class="right-nav-text">@lang('admin.sidebar.home')</span></div>
                <div class="clearfix"></div>
            </a>
        </li>
    @foreach($menuData as $menuClass)
    @if($menuClass->adminMenuItem()->where(['lang' => app()->getLocale(), 'parent' => '0', 'active' => 1])->count() > 0)
        <li><hr class="mb-0"></li>
        <li class="navigation-header"><span>{{ $menuClass->title }}</span><i class="icon-dots-three-horizontal"></i></li>
        @foreach($menuClass->adminMenuItem()->where(['lang' => app()->getLocale(), 'parent' => '0', 'active' => 1])->orderBy('sort')->get() as $menuParent)
        @if($menuParent->link === 'javascript:void(0);' && $menuParent->adminMenuItem(true)->where(['lang' => app()->getLocale(), 'active' => 1])->count() > 0)
        <li style="display: none;">
            <a class="collapsed {{ isset($pageData->parent) && ($pageData->parent === $menuParent->guid) ? 'active' : '' }}"
               href="javascript:void(0);"
               data-toggle="collapse"
               data-target="#Menu_{{ $menuParent->guid }}">
                <div class="float-left"><i class="{{ $menuParent->icon }}"></i><span class="right-nav-text">{{ $menuParent->title }}</span></div>
                <div class="float-right"><i class="icon-chevron-small-right"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul class="collapse collapse-level-1 {{ isset($pageData->parent) && ($pageData->parent === $menuParent->guid) ? 'show' : '' }}" id="Menu_{{ $menuParent->guid }}">
                @foreach($menuParent->adminMenuItem(true)->where(['lang' => app()->getLocale(), 'active' => 1])->orderBy('sort')->get() as $menuChild)
                @if($adminData->can($menuChild->permission_key))
                <li><a class="{{ isset($pageData->uri) && $pageData->uri === $menuChild->uri ? 'active' : '' }}" href="{{ url('siteadmin/' . $menuChild->link) }}">{{ $menuChild->title }}</a></li>
                @endif
                @endforeach
            </ul>
            <script id="menu_script_{{ $menuParent->guid }}">
            if(document.getElementById('Menu_{{ $menuParent->guid }}').getElementsByTagName("li").length < 1){
                let element = document.getElementById('Menu_{{ $menuParent->guid }}').parentNode; element && element.parentNode && element.parentNode.removeChild(element);
            } else {
                document.getElementById('Menu_{{ $menuParent->guid }}').parentNode.removeAttribute('style');
                let element = document.getElementById('menu_script_{{ $menuParent->guid }}'); element && element.parentNode && element.parentNode.removeChild(element);
            }
            </script>
        </li>
        @elseif($menuParent->link !== 'javascript:void(0);' && $adminData->can($menuParent->permission_key))
        <li>
            <a class="{{ isset($pageData->uri) && $pageData->uri === $menuParent->uri ? 'active' : '' }}" href="{{ url('siteadmin/' . $menuParent->link) }}">
                <div class="float-left"><i class="{{ $menuParent->icon }}"></i><span class="right-nav-text">{{ $menuParent->title }}</span></div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endif
        @endforeach
    @endif
    @endforeach
    </ul>
</nav>