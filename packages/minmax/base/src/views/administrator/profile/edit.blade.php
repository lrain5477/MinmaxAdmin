<?php
/**
 * @var \Minmax\Base\Models\Administrator $formData
 */
?>

@extends('MinmaxBase::administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::administrator.layouts.breadcrumbs', 'edit'))

@section('content')
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">@lang('MinmaxBase::administrator.header.account') @lang('MinmaxBase::administrator.form.edit')</h1>
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="editForm" class="form-horizontal validate editForm" name="editForm"
                  action="{{ langRoute('administrator.profile') }}"
                  method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                @inject('modelPresenter', 'Minmax\Base\Administrator\AdministratorPresenter')

                <fieldset id="baseFieldSet">
                    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

                    {!! $modelPresenter->getFieldNormalText($formData, 'username', ['required' => true]) !!}

                    {!! $modelPresenter->getFieldText($formData, 'name', ['required' => true, 'size' => 4]) !!}

                    {!! $modelPresenter->getFieldText($formData, 'allow_ip', ['hint' => true]) !!}

                </fieldset>

                <fieldset class="mt-4" id="advFieldSet">
                    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

                    {!! $modelPresenter->getFieldPassword($formData, 'password', ['size' => 4, 'hint' => true]) !!}

                    {!! $modelPresenter->getFieldPassword($formData, 'password_confirmation', ['size' => 4, 'hint' => true]) !!}

                </fieldset>

                <div class="text-center my-4 form-btn-group">
                    <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
                    <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
                </div>
            </form>
        </div>
    </div>
</section>
@endsection