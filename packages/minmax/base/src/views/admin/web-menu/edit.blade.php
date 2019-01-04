<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Base\Models\WebMenu $formData
 */
?>

@extends('MinmaxBase::admin.layouts.page.edit', ['formDataId' => $formData->id])

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links', ['languageActive' => $languageActive])
        @if($adminData->can('webMenuShow'))
        <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index", ['parent' => $formData->parent_id]) }}" title="@lang('MinmaxBase::admin.form.back_list')">
            <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.back_list')</span>
        </a>
        @endif
    @endcomponent
@endsection

@section('forms')
    @inject('modelPresenter', 'Minmax\Base\Admin\WebMenuPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

        @if($formData->editable)
        {!! $modelPresenter->getFieldSelect($formData, 'parent_id', ['required' => true]) !!}
        @else
        {!! $modelPresenter->getViewSelection($formData, 'parent_id') !!}
        @endif

        {!! $modelPresenter->getFieldText($formData, 'title', ['required' => true]) !!}

        @if($formData->editable)
        {!! $modelPresenter->getFieldText($formData, 'uri', ['hint' => true]) !!}
        @else
        {!! $modelPresenter->getViewNormalText($formData, 'uri') !!}
        @endif

        @if($formData->editable)
        {!! $modelPresenter->getFieldText($formData, 'link') !!}
        @else
        {!! $modelPresenter->getViewNormalText($formData, 'link') !!}
        @endif

        {!! $modelPresenter->getFieldRadio($formData, 'options', ['required' => true, 'inline' => true, 'subColumn' => 'target']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldText($formData, 'sort', ['required' => true, 'size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection