<?php
/**
 * Administrator site sidebar
 *
 * @var array $systemMenu (Items are model App)
 * @var \App\Models\AdministratorMenu $pageData
 * @var string $rootUri
 */
?>
<nav class="fixed-sidebar-left left-width">
    <ul class="side-nav nicescroll-bar">
    @foreach($systemMenu as $menuClass => $menuParents)
        @if(!$loop->first)
        <li><hr class="mb-0"></li>
        @endif
        <li class="navigation-header"><span>{{ $menuClass }}</span><i class="icon-dots-three-horizontal"></i></li>
        @foreach($menuParents as $menuParent)
        @if($menuParent['link'] == '' && count($menuParent['children']) > 0)
        <li>
            <a class="collapsed {{ !is_null($pageData) && ($pageData->parent_id == $menuParent['guid']) ? 'active' : '' }}"
               href="javascript:void(0);"
               data-toggle="collapse"
               data-target="#Menu_{{ $menuParent['guid'] }}">
                <div class="float-left"><i class="{{ $menuParent['icon'] }}"></i><span class="right-nav-text">{{ $menuParent['title'] }}</span></div>
                <div class="float-right"><i class="icon-chevron-small-right"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul class="collapse collapse-level-1 {{ !is_null($pageData) && ($pageData->parent_id == $menuParent['guid']) ? 'show' : '' }}" id="Menu_{{ $menuParent['guid'] }}">
                @foreach($menuParent['children'] as $menuChild)
                <li><a class="{{ !is_null($pageData) && $pageData->uri == $menuChild['uri'] ? 'active' : '' }}"
                       href="{{ preg_match("/^http/", $menuChild['link']) === 1 ? $menuChild['link'] : url($rootUri . $menuChild['link']) }}"
                       target="{{ preg_match("/^http/", $menuChild['link']) === 1 ? '_blank' : '_self' }}">{{ $menuChild['title'] }}</a></li>
                @endforeach
            </ul>
        </li>
        @elseif($menuParent['link'] != '')
        <li>
            <a class="{{ isset($pageData->uri) && $pageData->uri === $menuParent['uri'] ? 'active' : '' }}"
               href="{{ preg_match("/^http/", $menuParent['link']) === 1 ? $menuParent['link'] : url($rootUri . $menuParent['link']) }}"
               target="{{ preg_match("/^http/", $menuParent['link']) === 1 ? '_blank' : '_self' }}">
                <div class="float-left"><i class="{{ $menuParent['icon'] }}"></i><span class="right-nav-text">{{ $menuParent['title'] }}</span></div>
                <div class="clearfix"></div>
            </a>
        </li>
        @endif
        @endforeach
    @endforeach
    </ul>
</nav>