<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Product\Models\ProductPackage $formData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.create')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links', ['languageActive' => $languageActive])
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.back_list')</span>
    </a>
    @endcomponent
@endsection

@section('forms')
    @inject('modelPresenter', 'Minmax\Product\Administrator\ProductPackagePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'set_sku', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'item_sku', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'amount', ['required' => true, 'size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'limit', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'description') !!}

        {!! $modelPresenter->getFieldDynamicPriceList($formData, []) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldMultiSelect($formData, 'productMarkets', ['hint' => true]) !!}

        {!! $modelPresenter->getFieldDatePicker($formData, 'start_at', ['type' => 'datetime', 'size' => 3, 'hint' => true]) !!}

        {!! $modelPresenter->getFieldDatePicker($formData, 'end_at', ['type' => 'datetime', 'size' => 3, 'hint' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'sort', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection