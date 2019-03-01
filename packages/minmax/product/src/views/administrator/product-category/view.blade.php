<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Product\Models\ProductCategory $formData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.view')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links', ['languageActive' => $languageActive])
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index", ['parent' => $formData->parent_id]) }}" title="@lang('MinmaxBase::administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.back_list')</span>
    </a>
    <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('MinmaxBase::administrator.form.edit')">
        <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.edit')</span>
    </a>
    @endcomponent
@endsection

@section('views')
    @inject('modelPresenter', 'Minmax\Product\Administrator\ProductCategoryPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewSelection($formData, 'parent_id') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewMediaImage($formData, 'details', ['subColumn' => 'pic']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'details', ['subColumn' => 'description']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'details', ['subColumn' => 'editor']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'sort') !!}

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection