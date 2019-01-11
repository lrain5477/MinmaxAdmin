<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

<fieldset id="authenticationFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::admin.form.authentication')</legend>

    <table class="table table-sm table-bordered mb-1">
        <thead>
        <tr class="text-center">
            <th>@lang('MinmaxMember::admin.form.table.authentication.type')</th>
            <th>@lang('MinmaxMember::admin.form.table.authentication.token')</th>
            <th>@lang('MinmaxMember::admin.form.table.authentication.authenticated')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($formData->memberAuthentications->sortByDesc('created_at') as $memberAuthentication)
            <tr class="text-center">
                <td>{{ $memberAuthentication->type }}</td>
                <td class="w-50">{{ $memberAuthentication->token }}</td>
                <td>{{ $memberAuthentication->authenticated ? $memberAuthentication->authenticated_at : 'No' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</fieldset>
