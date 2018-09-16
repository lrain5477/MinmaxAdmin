<?php
/**
 * @var \App\Models\AdministratorMenu $pageData
 * @var \App\Models\WebData $formData
 */
?>

@extends('administrator.default.view')

@section('action-buttons')
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
    </a>
    <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.edit", [$formData->guid]) }}" title="@lang('administrator.form.edit')">
        <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.edit')</span>
    </a>
</div>
@endsection

@section('views')
    @inject('modelPresenter', 'App\Presenters\Administrator\WebDataPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'guard') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'website_name') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'system_email') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'system_url') !!}

    </fieldset>

    <fieldset class="mt-4" id="mediaFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.media')</legend>

        {!! $modelPresenter->getViewMediaImage($formData, 'system_logo', ['required' => true, 'limit' => 1, 'hint' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.information')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'company', ['subColumn' => 'name']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'phone']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'fax']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'email']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'address']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'lng', 'size' => 2]) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'lat', 'size' => 2]) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'map', 'size' => 2]) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'social', ['subColumn' => 'facebook']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'social', ['subColumn' => 'youtube']) !!}

    </fieldset>

    <fieldset class="mt-4" id="seoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.seo')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_description']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_keywords']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'google_analytics', $formData->google_analytics == '' ? '' : '(Hide)') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'offline_text') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection