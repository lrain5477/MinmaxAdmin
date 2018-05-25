@extends('administrator.default.create')

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\ParameterItemPresenter')

    {!! $modelPresenter->getFieldHidden($formData, 'lang', app()->getLocale()) !!}

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldSelect($formData, 'group', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'title', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'value', true) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldText($formData, 'class', ['hint' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'sort', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')">
    </div>
@endsection