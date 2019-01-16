<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Notify\Models\NotifyEmail $formData
 */
?>

@extends('MinmaxBase::admin.layouts.page.view')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links', ['languageActive' => $languageActive])
        @if($adminData->can('notifyEmailShow'))
        <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::admin.form.back_list')">
            <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.back_list')</span>
        </a>
        @endif
        @if($adminData->can('notifyEmailEdit'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.edit", [$formData->id]) }}" title="@lang('MinmaxBase::admin.form.edit')">
            <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.edit')</span>
        </a>
        @endif
    @endcomponent
@endsection

@section('views')
    @inject('modelPresenter', 'Minmax\Notify\Admin\NotifyEmailPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewSelection($formData, 'notifiable') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'receivers', ['defaultValue' => count($formData->receivers ?? [])]) !!}

    </fieldset>

    <fieldset class="mt-4" id="contentFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxNotify::admin.form.fieldSet.content')</legend>

        <div class="panel-wrapper">
            <div class="panel-body m-0 p-0">
                <header class="mb-4">
                    <ul class="nav nav-tabs" id="ioTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active"
                               id="tab-custom" data-toggle="tab"
                               href="#tab-pane-custom" role="tab"
                               aria-controls="tab-pane-custom" aria-selected="true">@lang('MinmaxNotify::admin.form.tab.custom')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="tab-admin" data-toggle="tab"
                               href="#tab-pane-admin" role="tab"
                               aria-controls="tab-pane-admin" aria-selected="true">@lang('MinmaxNotify::admin.form.tab.admin')</a>
                        </li>
                    </ul>
                </header>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-pane-custom" role="tabpanel" aria-labelledby="tab-custom">

                        {!! $modelPresenter->getViewNormalText($formData, 'custom_subject') !!}

                        {!! $modelPresenter->getViewNormalText($formData, 'custom_preheader') !!}

                        {!! $modelPresenter->getViewEditor($formData, 'custom_editor', ['height' => '550px']) !!}

                    </div>
                    <div class="tab-pane fade" id="tab-pane-admin" role="tabpanel" aria-labelledby="tab-admin">

                        {!! $modelPresenter->getViewNormalText($formData, 'admin_subject') !!}

                        {!! $modelPresenter->getViewNormalText($formData, 'admin_preheader') !!}

                        {!! $modelPresenter->getViewEditor($formData, 'admin_editor', ['height' => '550px']) !!}

                    </div>
                </div>
            </div>
        </div>

        @if(is_array($formData->replacements) && count($formData->replacements) > 0)
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <div class="note note-edfault mt-3">
                    <h6>@lang('MinmaxNotify::admin.form.fieldSet.replacement')</h6>
                    <small>
                        @foreach($formData->replacements as $replacementKey => $replacementValue)
                        <code class="mr-2">{[{{$replacementKey}}]}</code>{{ $replacementValue }}{{ $loop->last ? '' : '，' }}
                        @endforeach
                    </small>
                </div>
            </div>
        </div>
        @endif

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection