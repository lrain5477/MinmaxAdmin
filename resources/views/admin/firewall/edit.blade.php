@extends('admin.default.edit')

@section('action-buttons')
@if($adminData->can('firewallShow'))
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ route('admin.index', [$pageData->uri]) }}" title="@lang('admin.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
    </a>
</div>
@endif
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Admin\FirewallPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldSelect($formData, 'guard', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'ip', true) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'rule', true, ['inline' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection