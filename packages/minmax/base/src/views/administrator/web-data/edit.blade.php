<?php
/**
 * @var \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\WorldLanguage[] $languageActive
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Base\Models\WebData $formData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.edit', ['formDataId' => $formData->id])

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links', ['languageActive' => $languageActive])
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.back_list')</span>
    </a>
    @endcomponent
@endsection

@section('forms')
    @inject('modelPresenter', 'Minmax\Base\Administrator\WebDataPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'website_name', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'system_email', ['required' => true, 'type' => 'email']) !!}

        {!! $modelPresenter->getFieldText($formData, 'system_url', ['required' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="mediaFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.media')</legend>

        {!! $modelPresenter->getFieldMediaImage($formData, 'system_logo', ['required' => true, 'hint' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.information')</legend>

        {!! $modelPresenter->getFieldColumnExtension($formData, 'company') !!}

        {!! $modelPresenter->getFieldColumnExtension($formData, 'contact') !!}

        {!! $modelPresenter->getFieldColumnExtension($formData, 'social') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_description', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_keywords', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'options', ['subColumn' => 'head', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'options', ['subColumn' => 'body', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'options', ['subColumn' => 'foot', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'offline_text', ['hint' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection