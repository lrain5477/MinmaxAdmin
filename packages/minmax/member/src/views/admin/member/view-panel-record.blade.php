<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Member\Models\Member $formData
 */
?>

<fieldset id="recordFieldSet">
    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxMember::admin.form.record')</legend>

    <table class="table table-sm table-bordered mb-1">
        <thead>
        <tr class="text-center">
            <th>@lang('MinmaxMember::admin.form.table.record.created_at')</th>
            <th>@lang('MinmaxMember::admin.form.table.record.tag')</th>
            <th>@lang('MinmaxMember::admin.form.table.record.remark')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($formData->memberRecords->sortByDesc('created_at') as $memberRecord)
            <tr>
                <td>{{ $memberRecord->created_at }}</td>
                <td>{{ $memberRecord->details['tag'] ?? '' }}</td>
                <td>{{ $memberRecord->details['remark'] ?? '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</fieldset>
