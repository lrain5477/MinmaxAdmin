<?php
/**
 * Create page of model AdminMenu
 *
 * @var \App\Models\AdministratorMenu $pageData
 * @var \App\Models\AdminMenu $formData
 */
?>

@extends('administrator.default.create')

@section('action-buttons')
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
    </a>
</div>
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\AdminMenuPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'uri', ['required' => true, 'size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'title', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'controller') !!}

        {!! $modelPresenter->getFieldText($formData, 'model') !!}

        {!! $modelPresenter->getFieldText($formData, 'class', ['required' => true]) !!}

        {!! $modelPresenter->getFieldSelect($formData, 'parent_id') !!}

        {!! $modelPresenter->getFieldText($formData, 'link') !!}

        {!! $modelPresenter->getFieldText($formData, 'icon', ['hint' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'permission_key') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldText($formData, 'sort', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection