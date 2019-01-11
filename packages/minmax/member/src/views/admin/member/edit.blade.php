<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

@extends('MinmaxBase::admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::admin.layouts.breadcrumbs', 'edit'))

@section('content')
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('MinmaxBase::admin.form.edit')</h1>

        @component('MinmaxBase::admin.layouts.right-links')
            @if($adminData->can('memberShow'))
            <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::admin.form.back_list')">
                <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.back_list')</span>
            </a>
            @endif
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
                           aria-controls="tab-pane-account" aria-selected="true">@lang('MinmaxMember::admin.form.account')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="tab-profile" data-toggle="tab"
                           href="#tab-pane-profile" role="tab"
                           aria-controls="tab-pane-profile" aria-selected="true">@lang('MinmaxMember::admin.form.profile')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="tab-authentication" data-toggle="tab"
                           href="#tab-pane-authentication" role="tab"
                           aria-controls="tab-pane-authentication" aria-selected="true">@lang('MinmaxMember::admin.form.authentication')</a>
                    </li>
                </ul>
            </header>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-pane-account" role="tabpanel" aria-labelledby="tab-account">
                    @include('MinmaxMember::admin.member.edit-panel-account')
                </div>
                <div class="tab-pane fade" id="tab-pane-profile" role="tabpanel" aria-labelledby="tab-profile">
                    @include('MinmaxMember::admin.member.edit-panel-profile')
                </div>
                <div class="tab-pane fade" id="tab-pane-authentication" role="tabpanel" aria-labelledby="tab-authentication">
                    @include('MinmaxMember::admin.member.edit-panel-authentication')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection