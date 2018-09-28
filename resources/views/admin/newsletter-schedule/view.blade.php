<?php
/**
 * Review page of model NewsletterSchedule
 *
 * @var \App\Models\Admin $adminData
 * @var \App\Models\AdminMenu $pageData
 * @var \App\Models\NewsletterSchedule $formData
 */
?>

@extends('admin.default.view')

@section('action-buttons')
<div class="float-right">
    @if($adminData->can('newsletterScheduleShow'))
    <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('admin.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
    </a>
    @endif
    @if($adminData->can('newsletterScheduleEdit'))
    <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('admin.form.edit')">
        <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.edit')</span>
    </a>
    @endif
</div>
@endsection

@section('views')
    @inject('modelPresenter', 'App\Presenters\Admin\NewsletterSchedulePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'subject') !!}

        {!! $modelPresenter->getViewEditor($formData, 'content') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'schedule_at') !!}

        {!! $modelPresenter->getViewMultiSelection($formData, 'groups') !!}

        {!! $modelPresenter->getViewMultiSelection($formData, 'objects') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>
@endsection