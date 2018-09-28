<?php
/**
 * Create page of model NewsletterTemplate
 *
 * @var \App\Models\Admin $adminData
 * @var \App\Models\AdminMenu $pageData
 * @var \App\Models\NewsletterTemplate $formData
 */
?>

@extends('admin.default.create')

@section('action-buttons')
@if($adminData->can('newsletterTemplateShow'))
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('admin.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
    </a>
</div>
@endif
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Admin\NewsletterTemplatePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'title', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'subject', ['required' => true]) !!}

        {!! $modelPresenter->getFieldEditor($formData, 'content', ['required' => true, 'height' => '550px']) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection