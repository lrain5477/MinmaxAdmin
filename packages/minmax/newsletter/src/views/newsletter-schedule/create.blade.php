<?php
/**
 * Create page of model NewsletterSchedule
 *
 * @var \App\Models\Admin $adminData
 * @var \App\Models\AdminMenu $pageData
 * @var \App\Models\NewsletterSchedule $formData
 */
?>

@extends('admin.default.create')

@section('action-buttons')
@if($adminData->can('newsletterScheduleShow'))
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('admin.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
    </a>
</div>
@endif
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Admin\NewsletterSchedulePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'title', ['required' => true]) !!}

        {!! $modelPresenter->getFieldTemplateSelection() !!}

        {!! $modelPresenter->getFieldText($formData, 'subject', ['required' => true]) !!}

        {!! $modelPresenter->getFieldEditor($formData, 'content', ['required' => true, 'height' => '550px']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldDatePicker($formData, 'schedule_at', ['type' => 'birthdateTime']) !!}

        {!! $modelPresenter->getFieldMultiSelect($formData, 'groups') !!}

        {!! $modelPresenter->getFieldMultiSelect($formData, 'objects') !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection