<?php
/**
 * @var \Illuminate\Support\Collection $menuData
 */
?>
<nav class="fixed-sidebar-left left-width">
    <ul class="side-nav nicescroll-bar">
        <li class="navigation-header"><span>default</span><i class="icon-dots-three-horizontal"></i></li>
        <li>
            <a class="{{ Route::currentRouteName() === 'administrator.home' ? 'active' : '' }}" href="{{ route('administrator.home') }}">
                <div class="float-left"><i class="icon-home3"></i><span class="right-nav-text">@lang('administrator.sidebar.home')</span></div>
                <div class="clearfix"></div>
            </a>
        </li>

    @foreach($menuData as $menuLayer1)
        @if($loop->first)
        <li><hr class="mb-0"></li>
        <li class="navigation-header"><span>{{ $menuLayer1->class }}</span><i class="icon-dots-three-horizontal"></i></li>
        @endif
        <li>
            @if($menuLayer1->administratorMenu(true)->count() > 0)
            <a class="collapsed {{ isset($pageData->parent) && ($pageData->parent === $menuLayer1->uri) ? 'active' : '' }}"
               href="javascript:void(0);"
               data-toggle="collapse"
               data-target="#Menu_{{ $menuLayer1->uri }}">
                <div class="float-left"><i class="{{ $menuLayer1->icon }}"></i><span class="right-nav-text">{{ $menuLayer1->title }}</span></div>
                <div class="float-right"><i class="icon-chevron-small-right"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul class="collapse collapse-level-1 {{ isset($pageData->parent) && ($pageData->parent === $menuLayer1->uri) ? 'show' : '' }}" id="Menu_{{ $menuLayer1->uri }}">
                @foreach($menuLayer1->administratorMenu(true)->orderBy('sort')->get() as $menuLayer2)
                <li><a class="{{ isset($pageData->uri) && $pageData->uri === $menuLayer2->uri ? 'active' : '' }}" href="{{ url('administrator/' . $menuLayer2->link) }}">{{ $menuLayer2->title }}</a></li>
                @endforeach
            </ul>
            @else
            <a class="{{ isset($pageData->uri) && $pageData->uri === $menuLayer1->uri ? 'active' : '' }}" href="{{ url('administrator/' . $menuLayer1->link) }}">
                <div class="float-left"><i class="{{ $menuLayer1->icon }}"></i><span class="right-nav-text">{{ $menuLayer1->title }}</span></div>
                <div class="clearfix"></div>
            </a>
            @endif
        </li>
    @endforeach
    </ul>
</nav>