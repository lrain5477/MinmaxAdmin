<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Product\Models\ProductSet $formData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.view')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links', ['languageActive' => $languageActive])
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.back_list')</span>
    </a>
    <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('MinmaxBase::administrator.form.edit')">
        <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.edit')</span>
    </a>
    @endcomponent
@endsection

@section('views')
    @inject('modelPresenter', 'Minmax\Product\Administrator\ProductSetPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'sku') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'serial') !!}

        {!! $modelPresenter->getViewSelection($formData, 'brand_id') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'categories', ['defaultValue' => $formData->productCategories->pluck('title')->implode(', ')]) !!}

        {!! $modelPresenter->getViewMediaImage($formData, 'pic') !!}

        {!! $modelPresenter->getViewColumnExtension($formData, 'details') !!}

        {!! $modelPresenter->getViewSelection($formData, 'rank') !!}

    </fieldset>

    @if(in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers')))
    <fieldset class="mt-4" id="ecommerceFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxProduct::administrator.form.fieldSet.ecommerce')</legend>

        {!! $modelPresenter->getViewColumnExtension($formData, 'ec_parameters') !!}

    </fieldset>
    @endif

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'start_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'end_at') !!}

        {!! $modelPresenter->getViewSelection($formData, 'searchable') !!}

        {!! $modelPresenter->getViewSelection($formData, 'visible') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'sort') !!}

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="seoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.seo')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_description']) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'seo', ['subColumn' => 'meta_keywords']) !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection