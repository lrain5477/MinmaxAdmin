@extends('administrator.default.edit')

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\EditorTemplatePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldSelect($formData, 'guard', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'category', true, ['size' => 4]) !!}

        {!! $modelPresenter->getFieldText($formData, 'title', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'description', true) !!}

        {!! $modelPresenter->getFieldEditor($formData, 'editor', true, ['height' => '550px']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldText($formData, 'sort', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')">
    </div>
@endsection