<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

@inject('modelPresenter', 'Minmax\Member\Administrator\MemberPresenter')

<fieldset id="baseFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.default')</legend>

    {!! $modelPresenter->getViewNormalText($formData, 'username') !!}

    {!! $modelPresenter->getViewNormalText($formData, 'name') !!}

    {!! $modelPresenter->getViewNormalText($formData, 'email') !!}

</fieldset>

<fieldset class="mt-4" id="advFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.advanced')</legend>

    {!! $modelPresenter->getViewNormalText($formData, 'role_id', ['defaultValue' => $formData->roles->pluck('display_name')->implode(', ')]) !!}

    {!! $modelPresenter->getViewNormalText($formData, 'expired_at') !!}

    {!! $modelPresenter->getViewSelection($formData, 'active') !!}

</fieldset>

<fieldset class="mt-4" id="sysFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::administrator.form.fieldSet.system_record')</legend>

    {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

    {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

</fieldset>
