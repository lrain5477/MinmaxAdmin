@extends('administrator.default.edit')

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\MerchantMenuClassPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>主要設定</legend>

        {!! $modelPresenter->getFieldText($formData, 'title', true) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>進階選項</legend>

        {!! $modelPresenter->getFieldText($formData, 'sort', true, ['size' => 2]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection