<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Product\Models\ProductSet $formData
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
    @inject('modelPresenter', 'Minmax\Product\Administrator\ProductSetPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'title', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'sku', ['required' => true, 'hint' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'serial', ['hint' => true]) !!}

        {!! $modelPresenter->getFieldSelect($formData, 'brand_id', ['size' => 4]) !!}

        {!! $modelPresenter->getFieldCategorySelection($formData) !!}

        {!! $modelPresenter->getFieldColumnExtension($formData, 'details') !!}

        {!! $modelPresenter->getFieldSelect($formData, 'rank', ['size' => 2, 'required' => true]) !!}

        {!! $modelPresenter->getFieldTagsInput($formData) !!}

    </fieldset>

    <fieldset class="mt-4" id="mediaFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.media')</legend>

        {!! $modelPresenter->getFieldMediaImage($formData, 'pic', ['limit' => 1, 'hint' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="specFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxProduct::administrator.form.fieldSet.spec')</legend>

        {!! $modelPresenter->getFieldDynamicSpecificationList($formData) !!}

        {!! $modelPresenter->getFieldText($formData, 'spec_group', ['size' => 4]) !!}

    </fieldset>

    @if(in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers')))
    <fieldset class="mt-4" id="ecommerceFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxProduct::administrator.form.fieldSet.ecommerce')</legend>

        {!! $modelPresenter->getFieldColumnExtension($formData, 'ec_parameters') !!}

    </fieldset>
    @endif

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldCheckbox($formData, 'properties', ['inline' => true]) !!}

        {!! $modelPresenter->getFieldDatePicker($formData, 'start_at', ['type' => 'datetime', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldDatePicker($formData, 'end_at', ['type' => 'datetime', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'searchable', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'visible', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'sort', ['required' => true, 'size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="seoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.seo')</legend>

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_description', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_keywords', 'hint' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection