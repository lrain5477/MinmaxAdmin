<?php
/**
 * @var \App\Models\AdministratorMenu $pageData
 * @var \App\Models\Admin $formData
 */
?>

@extends('administrator.default.edit')

@section('action-buttons')
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
    </a>
</div>
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\AdminPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'username', ['required' => true]) !!}

        {!! $modelPresenter->getFieldPassword($formData, 'password', ['size' => 4, 'hint' => true]) !!}

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="Admin-password_confirmation">@lang('models.Admin.password_confirmation')</label>
            <div class="col-sm-4">
                <input type="password" class="form-control"
                       id="Admin-password_confirmation"
                       name="Admin[password_confirmation]"
                       placeholder="" />
            </div>
            <small class="form-text text-muted ml-sm-auto col-sm-10">@lang('models.Admin.hint.password_confirmation')</small>
        </div>

        {!! $modelPresenter->getFieldText($formData, 'name', ['required' => true]) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'email') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldRoleSelect($formData, 'role_id', ['required' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection