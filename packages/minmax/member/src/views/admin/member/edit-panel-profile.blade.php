<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

<form id="accountForm" class="form-horizontal validate editForm" name="accountForm"
      action="{{ langRoute("admin.{$pageData->uri}-detail.update", ['id' => $formData->id]) }}"
      method="post"
      enctype="multipart/form-data">
    @method('PUT')
    @csrf

    @inject('modelPresenter', 'Minmax\Member\Admin\MemberDetailPresenter')

    <fieldset id="accountFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::admin.form.profile')</legend>

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
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
</form>
