<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

@inject('modelPresenter', 'Minmax\Member\Admin\MemberPresenter')

<fieldset id="baseFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

    {!! $modelPresenter->getViewNormalText($formData, 'username') !!}

    {!! $modelPresenter->getViewNormalText($formData, 'name') !!}

    {!! $modelPresenter->getViewNormalText($formData, 'email') !!}

</fieldset>

<fieldset class="mt-4" id="advFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

    {!! $modelPresenter->getViewNormalText($formData, 'role_id', ['defaultValue' => $formData->roles->pluck('display_name')->implode(', ')]) !!}

    {!! $modelPresenter->getViewNormalText($formData, 'expired_at') !!}

    {!! $modelPresenter->getViewSelection($formData, 'active') !!}

</fieldset>

<fieldset class="mt-4" id="sysFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.system_record')</legend>

    {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

    {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

</fieldset>
