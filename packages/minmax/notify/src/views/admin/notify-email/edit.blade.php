<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Notify\Models\NotifyEmail $formData
 */
?>

@extends('MinmaxBase::admin.layouts.page.edit', ['formDataId' => $formData->id])

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links', ['languageActive' => $languageActive])
        @if($adminData->can('notifyEmailShow'))
        <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::admin.form.back_list')">
            <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.back_list')</span>
        </a>
        @endif
    @endcomponent
@endsection

@section('forms')
    @inject('modelPresenter', 'Minmax\Notify\Admin\NotifyEmailPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'title', ['required' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'notifiable', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldMultiSelect($formData, 'receivers', ['group' => true]) !!}

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

                        {!! $modelPresenter->getFieldText($formData, 'custom_subject') !!}

                        {!! $modelPresenter->getFieldText($formData, 'custom_preheader', ['hint' => true]) !!}

                        {!! $modelPresenter->getFieldEditor($formData, 'custom_editor', ['height' => '550px']) !!}

                    </div>
                    <div class="tab-pane fade" id="tab-pane-admin" role="tabpanel" aria-labelledby="tab-admin">

                        {!! $modelPresenter->getFieldText($formData, 'admin_subject') !!}

                        {!! $modelPresenter->getFieldText($formData, 'admin_preheader', ['hint' => true]) !!}

                        {!! $modelPresenter->getFieldEditor($formData, 'admin_editor', ['height' => '550px']) !!}

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

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection