<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

<form id="accountForm" class="form-horizontal validate editForm" name="accountForm"
      action="{{ langRoute("administrator.{$pageData->uri}-detail.update", ['id' => $formData->id]) }}"
      method="post"
      enctype="multipart/form-data">
    @method('PUT')
    @csrf

    @inject('modelPresenter', 'Minmax\Member\Administrator\MemberDetailPresenter')

    <fieldset id="accountFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::administrator.form.profile')</legend>

        {!! $modelPresenter->getFieldDynamicOptionText($formData->memberDetail, 'name', ['required' => true]) !!}

    </fieldset>

    <fieldset class="mt-4">
        <legend class="legend mb-4"></legend>

        {!! $modelPresenter->getFieldDynamicOptionText($formData->memberDetail, 'contact') !!}

    </fieldset>

    <fieldset class="mt-4">
        <legend class="legend mb-4"></legend>

        {!! $modelPresenter->getFieldDynamicOptionText($formData->memberDetail, 'social') !!}

    </fieldset>

    <fieldset class="mt-4">
        <legend class="legend mb-4"></legend>

        {!! $modelPresenter->getFieldDynamicOptionText($formData->memberDetail, 'profile') !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
</form>
