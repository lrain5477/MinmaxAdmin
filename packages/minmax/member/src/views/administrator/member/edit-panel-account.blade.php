<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

<form id="editForm" class="form-horizontal validate editForm" name="editForm"
      action="{{ langRoute("administrator.{$pageData->uri}.update", ['id' => $formData->id]) }}"
      method="post"
      enctype="multipart/form-data">
    @method('PUT')
    @csrf

    @inject('modelPresenter', 'Minmax\Member\Administrator\MemberPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'username', ['required' => true]) !!}

        {!! $modelPresenter->getFieldPassword($formData, 'password', ['size' => 4, 'hint' => true]) !!}

        {!! $modelPresenter->getFieldPassword($formData, 'password_confirmation', ['size' => 4, 'hint' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'name', ['required' => true]) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'email') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldRolesSelect($formData) !!}

        {!! $modelPresenter->getFieldDatePicker($formData, 'expired_at', ['size' => 3, 'type' => 'datetime', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
</form>
