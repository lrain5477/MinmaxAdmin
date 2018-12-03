<?php
/**
 * @var \Minmax\Base\Models\Admin $formData
 */
?>

@extends('MinmaxBase::admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::admin.layouts.breadcrumbs', 'edit'))

@section('content')
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">@lang('MinmaxBase::admin.header.account') @lang('MinmaxBase::admin.form.edit')</h1>
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="editForm" class="form-horizontal validate editForm"  name="editForm"
                  action="{{ langRoute('admin.profile') }}"
                  method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                @inject('modelPresenter', 'Minmax\Base\Admin\AdminPresenter')

                <fieldset id="baseFieldSet">
                    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

                    {!! $modelPresenter->getFieldNormalText($formData, 'username', ['required' => true]) !!}

                    {!! $modelPresenter->getFieldText($formData, 'name', ['required' => true, 'size' => 4]) !!}

                    {!! $modelPresenter->getFieldEmail($formData, 'email', ['required' => true]) !!}

                </fieldset>

                <fieldset class="mt-4" id="advFieldSet">
                    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

                    {!! $modelPresenter->getFieldPassword($formData, 'password', ['size' => 4, 'hint' => true]) !!}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="Admin-password_confirmation">@lang('MinmaxBase::models.Admin.password_confirmation')</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control"
                                   id="Admin-password_confirmation"
                                   name="Admin[password_confirmation]"
                                   placeholder=""
                                   autocomplete="off" />
                        </div>
                        <small class="form-text text-muted ml-sm-auto col-sm-10">@lang('MinmaxBase::models.Admin.hint.password_confirmation')</small>
                    </div>

                </fieldset>

                <div class="text-center my-4 form-btn-group">
                    <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::admin.form.button.send')">
                    <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::admin.form.button.reset')" onclick="window.location.reload(true)">
                </div>
            </form>
        </div>
    </div>
</section>
@endsection