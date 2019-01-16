<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Base\Models\WorldLanguage $formData
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
    @inject('modelPresenter', 'Minmax\World\Administrator\WorldLanguagePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'code', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'name', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'native', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'options', ['required' => true, 'subColumn' => 'icon', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'options', ['required' => true, 'subColumn' => 'script']) !!}

        {!! $modelPresenter->getFieldText($formData, 'options', ['required' => true, 'subColumn' => 'regional']) !!}

        {!! $modelPresenter->getFieldSelect($formData, 'currency_id', ['required' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldText($formData, 'sort', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active_admin', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection