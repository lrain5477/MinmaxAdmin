<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Base\Models\WebData $formData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.view')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links')
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.back_list')</span>
    </a>
    <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('MinmaxBase::administrator.form.edit')">
        <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.edit')</span>
    </a>
    @endcomponent
@endsection

@section('views')
    @inject('modelPresenter', 'Minmax\Base\Administrator\WebDataPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewSelection($formData, 'guard') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'website_name') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'system_email') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'system_url') !!}

    </fieldset>

    <fieldset class="mt-4" id="mediaFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.media')</legend>

        {!! $modelPresenter->getViewMediaImage($formData, 'system_logo') !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.information')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'company', ['subColumn' => 'name']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'phone']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'fax']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'email']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'address']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'lng']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'lat']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'contact', ['subColumn' => 'map']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'social', ['subColumn' => 'facebook', 'icon' => 'icon-facebook3']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'social', ['subColumn' => 'instagram', 'icon' => 'icon-instagram2']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'social', ['subColumn' => 'youtube', 'icon' => 'icon-youtube2']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_description']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_keywords']) !!}

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'offline_text') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection