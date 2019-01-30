<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Product\Models\ProductSet $formData
 */
?>

@extends('MinmaxBase::admin.layouts.page.view')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links', ['languageActive' => $languageActive])
        @if($adminData->can('productSetShow'))
        <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::admin.form.back_list')">
            <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.back_list')</span>
        </a>
        @endif
        @if($adminData->can('productSetEdit'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('MinmaxBase::admin.form.edit')">
            <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.edit')</span>
        </a>
        @endif
    @endcomponent
@endsection

@section('views')
    @inject('modelPresenter', 'Minmax\Product\Admin\ProductSetPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'sku') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'serial') !!}

        {!! $modelPresenter->getViewSelection($formData, 'brand_id') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'categories', ['defaultValue' => $formData->productCategories->pluck('title')->implode(', ')]) !!}

        {!! $modelPresenter->getViewMediaImage($formData, 'pic') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'details', ['subColumn' => 'description']) !!}

        {!! $modelPresenter->getViewEditor($formData, 'details', ['subColumn' => 'feature']) !!}

        {!! $modelPresenter->getViewEditor($formData, 'details', ['subColumn' => 'detail']) !!}

        {!! $modelPresenter->getViewEditor($formData, 'details', ['subColumn' => 'specification']) !!}

        {!! $modelPresenter->getViewEditor($formData, 'details', ['subColumn' => 'video']) !!}

        {!! $modelPresenter->getViewEditor($formData, 'details', ['subColumn' => 'accessory']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewSelection($formData, 'searchable') !!}

        {!! $modelPresenter->getViewSelection($formData, 'visible') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'sort') !!}

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="seoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.seo')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_description']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_keywords']) !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection