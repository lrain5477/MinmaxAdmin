<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

<fieldset id="accountFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::models.MemberDetail.name')</legend>

    @foreach($formData->memberDetail->name ?? [] as $attributeKey => $attributeValue)
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="Member-name-{{ $attributeKey }}">
            {{ $attributeKey }}
        </label>
        <div class="col-sm-10">
            <div class="form-text" id="Member-name-{{ $attributeKey }}">{{ $attributeValue }}</div>
        </div>
    </div>
    @endforeach

</fieldset>

<fieldset class="mt-4">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::models.MemberDetail.contact')</legend>

    @foreach($formData->memberDetail->contact ?? [] as $attributeKey => $attributeValue)
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="Member-contact-{{ $attributeKey }}">
            {{ $attributeKey }}
        </label>
        <div class="col-sm-10">
            <div class="form-text" id="Member-contact-{{ $attributeKey }}">{{ $attributeValue }}</div>
        </div>
    </div>
    @endforeach

</fieldset>

<fieldset class="mt-4">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::models.MemberDetail.social')</legend>

    @foreach($formData->memberDetail->social ?? [] as $attributeKey => $attributeValue)
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="Member-social-{{ $attributeKey }}">
                {{ $attributeKey }}
            </label>
            <div class="col-sm-10">
                <div class="form-text" id="Member-social-{{ $attributeKey }}">{{ $attributeValue }}</div>
            </div>
        </div>
    @endforeach

</fieldset>

<fieldset class="mt-4">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::models.MemberDetail.profile')</legend>

    @foreach($formData->memberDetail->profile ?? [] as $attributeKey => $attributeValue)
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="Member-profile-{{ $attributeKey }}">
                {{ $attributeKey }}
            </label>
            <div class="col-sm-10">
                <div class="form-text" id="Member-profile-{{ $attributeKey }}">{{ $attributeValue }}</div>
            </div>
        </div>
    @endforeach

</fieldset>
