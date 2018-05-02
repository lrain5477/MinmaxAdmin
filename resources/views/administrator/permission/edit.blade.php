@extends('administrator.default.edit')

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\PermissionPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>主要設定</legend>

        {!! $modelPresenter->getFieldSelect($formData, 'guard', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'name', true, ['size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'display_name', true, ['size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'group', true, ['size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'label', true, ['size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'description') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>進階選項</legend>

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')">
    </div>
@endsection