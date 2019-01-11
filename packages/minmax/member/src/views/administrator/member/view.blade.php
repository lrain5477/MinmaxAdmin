<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

@extends('MinmaxBase::administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::administrator.layouts.breadcrumbs', 'view'))

@section('content')
    <!-- layout-content-->
    <section class="panel panel-default">
        <header class="panel-heading">
            <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('MinmaxBase::administrator.form.view')</h1>

            @component('MinmaxBase::admin.layouts.right-links')
            <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::administrator.form.back_list')">
                <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.back_list')</span>
            </a>
            <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('MinmaxBase::administrator.form.edit')">
                <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.edit')</span>
            </a>
            @endcomponent
        </header>

        <div class="panel-wrapper">
            <div class="panel-body">
                <header class="mb-4">
                    <ul class="nav nav-tabs" id="ioTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active"
                               id="tab-account" data-toggle="tab"
                               href="#tab-pane-account" role="tab"
                               aria-controls="tab-pane-account" aria-selected="true">@lang('MinmaxMember::administrator.form.account')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="tab-profile" data-toggle="tab"
                               href="#tab-pane-profile" role="tab"
                               aria-controls="tab-pane-profile" aria-selected="true">@lang('MinmaxMember::administrator.form.profile')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="tab-authentication" data-toggle="tab"
                               href="#tab-pane-authentication" role="tab"
                               aria-controls="tab-pane-authentication" aria-selected="true">@lang('MinmaxMember::administrator.form.authentication')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="tab-record" data-toggle="tab"
                               href="#tab-pane-record" role="tab"
                               aria-controls="tab-pane-record" aria-selected="true">@lang('MinmaxMember::administrator.form.record')</a>
                        </li>
                    </ul>
                </header>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-pane-account" role="tabpanel" aria-labelledby="tab-account">
                        @include('MinmaxMember::administrator.member.view-panel-account')
                    </div>
                    <div class="tab-pane fade" id="tab-pane-profile" role="tabpanel" aria-labelledby="tab-profile">
                        @include('MinmaxMember::administrator.member.view-panel-profile')
                    </div>
                    <div class="tab-pane fade" id="tab-pane-authentication" role="tabpanel" aria-labelledby="tab-authentication">
                        @include('MinmaxMember::administrator.member.view-panel-authentication')
                    </div>
                    <div class="tab-pane fade" id="tab-pane-record" role="tabpanel" aria-labelledby="tab-record">
                        @include('MinmaxMember::administrator.member.view-panel-record')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / layout-content-->
@endsection
