@extends('admin.default.edit')

@section('action-buttons')
@if($adminData->can('adminShow'))
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ route('admin.index', [$pageData->uri]) }}" title="@lang('admin.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
    </a>
</div>
@endif
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Admin\AdminPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>主要設定</legend>

        {!! $modelPresenter->getFieldSelect($formData, 'role_id', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'username', true) !!}

        {!! $modelPresenter->getFieldPassword($formData, 'password', false, ['size' => 4, 'hint' => true]) !!}

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

        {!! $modelPresenter->getFieldText($formData, 'name', true) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'email') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>進階選項</legend>

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('admin.form.button.reset')">
    </div>
@endsection