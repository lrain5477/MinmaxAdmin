<?php
/**
 * @var \App\Models\WebData $webData
 * @var \Illuminate\Database\Eloquent\Collection|\App\Models\WorldLanguage[] $languageData
 */
?>
<div class="page-header fixed-top">
    <h1 class="navbar-brand left-width pl-3 navbar navbar-expand-lg"><a class="font-weight-bold text-uppercase" href="{{ langRoute('administrator.home') }}"><img class="mr-1 align-middle" src="{{ isset($webData->system_logo[0]['path']) ? asset($webData->system_logo[0]['path']) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' }}"></a></h1>
    <button class="btn btn-link toggle-left-nav-btn no-decoration" id="toggle_nav_btn" type="button"><span class="text-hide">@lang('administrator.header.menu')</span><span class="line"></span></button>
    <div class="top-right pr-2 mt-1">
        @if(isset($languageData) && $languageData->count() > 1)
        <div class="d-inline-block dropdown globe">
            <button class="btn btn-link text-secondary dropdown-toggle px-2" id="menu-globe" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-globe h4"></i><span class="text-hide">>@lang('administrator.header.language')</span></button>
            <div class="dropdown-menu dropdown-menu-right rounded-0" aria-labelledby="menu-globe">
                @foreach($languageData as $languageItem)
                <a class="dropdown-item {{ app()->getLocale() == $languageItem->code ? 'active' : '' }}"
                   href="{{ preg_replace(['/\/'.app()->getLocale().'\//i', '/\/'.app()->getLocale().'$/i'], ["/{$languageItem->code}/"], url()->current()) }}">
                    <i class="img-thumbnail flag flag-icon-background {{ $languageItem->icon }}"></i><span>{{ $languageItem->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif
        <div class="d-inline-block dropdown globe">
            <button class="btn btn-link text-secondary dropdown-toggle px-2" id="menu-profile" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-user h4"></i><span class="text-hide">>@lang('administrator.header.account')</span></button>
            <div class="dropdown-menu dropdown-menu-right rounded-0" aria-labelledby="menu-profile">
                <a class="dropdown-item" href="{{ langRoute('administrator.profile') }}"><i class="icon-vcard"></i><span>@lang('administrator.header.profile')</span></a>
                <a class="dropdown-item" href="{{ langRoute('administrator.logout') }}"><i class="icon-log-out"></i><span>@lang('administrator.header.logout')</span></a>
            </div>
        </div>
    </div>
</div>