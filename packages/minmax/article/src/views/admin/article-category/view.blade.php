<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Article\Models\ArticleCategory $formData
 */
?>

@extends('MinmaxBase::admin.layouts.page.view')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links', ['languageActive' => $languageActive])
        @if($adminData->can('articleCategoryShow'))
        <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index", ['parent' => $formData->parent_id]) }}" title="@lang('MinmaxBase::admin.form.back_list')">
            <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.back_list')</span>
        </a>
        @endif
        @if($adminData->can('articleCategoryEdit'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('MinmaxBase::admin.form.edit')">
            <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.edit')</span>
        </a>
        @endif
    @endcomponent
@endsection

@section('views')
    @inject('modelPresenter', 'Minmax\Article\Admin\ArticleCategoryPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewSelection($formData, 'parent_id') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewDetails($formData) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'uri') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'sort') !!}

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection