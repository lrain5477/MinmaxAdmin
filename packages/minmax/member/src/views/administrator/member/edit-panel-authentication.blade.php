<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

<fieldset id="authenticationFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::administrator.form.authentication')</legend>

    <table class="table table-sm table-bordered mb-1">
        <thead>
        <tr class="text-center">
            <th>@lang('MinmaxMember::administrator.form.table.authentication.type')</th>
            <th>@lang('MinmaxMember::administrator.form.table.authentication.token')</th>
            <th>@lang('MinmaxMember::administrator.form.table.authentication.authenticated')</th>
            <th>@lang('MinmaxMember::administrator.form.table.authentication.actions')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($formData->memberAuthentications->sortByDesc('created_at') as $memberAuthentication)
        <tr class="text-center">
            <td>{{ $memberAuthentication->type }}</td>
            <td class="w-50">{{ $memberAuthentication->token }}</td>
            <td>{{ $memberAuthentication->authenticated ? $memberAuthentication->authenticated_at : 'No' }}</td>
            <td class="text-nowrap">
                @if(! $memberAuthentication->authenticated)
                <a class="btn btn-sm btn-danger mr-1"
                   href="{{ langRoute("administrator.{$pageData->uri}-authentication.authenticate", ['token' => $memberAuthentication->token]) }}"
                   title="@lang('MinmaxMember::administrator.form.table.authentication.do-auth')"><i class="icon-user-check"></i></a>
                @endif
                <form action="{{ langRoute("administrator.{$pageData->uri}-authentication.destroy", ['token' => $memberAuthentication->token]) }}" method="post" style="display: inline">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-secondary" type="submit"
                       title="@lang('MinmaxMember::administrator.form.table.authentication.do-remove')"><i class="icon-cross"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">
                <form action="{{ langRoute("administrator.{$pageData->uri}-authentication.store", ['id' => $formData->id]) }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="text" name="MemberAuthentication[type]" placeholder="@lang('MinmaxMember::administrator.form.table.authentication.type')" required />
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="icon-plus2 align-middle mr-2"></i>@lang('MinmaxMember::administrator.form.table.authentication.do-add')</button>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </tfoot>
    </table>

</fieldset>
