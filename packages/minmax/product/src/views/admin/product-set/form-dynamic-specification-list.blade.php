<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var array $values
 * @var \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\SiteParameterGroup[] $listData
 *
 * Options
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-10" id="{{ $id }}">
        <table class="table table-sm table-bordered mb-1">
            <thead class="thead-default">
            <tr class="text-center">
                <th>@lang("MinmaxProduct::admin.form.{$name}.specification_name")</th>
                <th>@lang("MinmaxProduct::admin.form.{$name}.specification_value")</th>
                <th>@lang("MinmaxProduct::admin.form.{$name}.actions")</th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach($listData as $paramItem)
                @if(count(array_intersect(array_keys($paramItem->children), $values)) > 0)
                <tr>
                    <td>
                        {{ $paramItem->title }}
                    </td>
                    <td>
                        @php
                        $firstItem = collect($paramItem->children)->first(function ($item, $key) use ($values) { return in_array($key, $values); });
                        @endphp
                        {{ is_null($firstItem) ? '' : $firstItem['title'] }}
                        <input type="hidden" name="{{ $name }}[specifications][]" value="{{ array_intersect(array_keys($paramItem->children), $values)[0] ?? '' }}" />
                    </td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-danger btn-sm repeat-remove" type="button"><i class="icon-cross"></i></button>
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td class="text-center">
                    <select class="form-control bs-select repeat-key" data-style="btn-outline-light btn-sm">
                        <option value="">@lang("MinmaxProduct::admin.form.{$name}.please_select")</option>
                        @foreach ($listData as $paramItem)
                        <option value="{{ $paramItem->code }}" {{ count(array_intersect(array_keys($paramItem->children), $values)) > 0 ? 'disabled' : '' }}>{{ $paramItem->title }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="text-center">
                    <select class="form-control bs-select repeat-value" data-style="btn-outline-light btn-sm" disabled>
                        <option value="">@lang("MinmaxProduct::admin.form.{$name}.please_select")</option>
                    </select>
                </td>
                <td class="text-center text-nowrap">
                    <button type="button" class="btn btn-primary btn-sm repeat-add"><i class="icon-plus"></i></button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>

<template id="template-{{ $id }}">
    <tr>
        <td>DUMP_SPEC</td>
        <td>DUMP_LABEL<input type="hidden" name="ProductSet[specifications][]" value="DUMP_VALUE" /></td>
        <td class="text-center text-nowrap">
            <button class="btn btn-danger btn-sm repeat-remove" type="button"><i class="icon-cross"></i></button>
        </td>
    </tr>
</template>

@push('scripts')
<script>
(function ($) {
    $(function () {
        var specificationSet = JSON.parse("{!! addslashes($listData->mapWithKeys(function ($item) { return [$item->code => $item->children]; })->toJson()) !!}");

        function refreshSpecificationList() {
            $('#{{ $id }} table > tfoot select.repeat-key option').prop('disabled', false);
            $('#{{ $id }} table > tbody input[name^="{{ $name }}[specifications]"]').each(function() {
                var $this = $(this);
                var specValue = $this.val();
                for (var key in specificationSet) {
                    if (specificationSet.hasOwnProperty(key)) {
                        if (specificationSet[key].hasOwnProperty(specValue)) {
                            $('#{{ $id }} table > tfoot select.repeat-key option[value="' + key + '"]').prop('disabled', true);
                        }
                    }
                }
            });
            $('#{{ $id }} table > tfoot select.repeat-key').selectpicker('refresh');
            $('#{{ $id }} table > tfoot select.repeat-key').selectpicker('val', '');
            $('#{{ $id }} table > tfoot select.repeat-value').selectpicker('val', '');
            refreshSpecificationItems();
        }

        function refreshSpecificationItems() {
            $('#{{ $id }} table > tfoot select.repeat-value').html('<option value="">@lang("MinmaxProduct::admin.form.{$name}.please_select")</option>');
            $('#{{ $id }} table > tfoot select.repeat-value').prop('disabled', true);
            var specification = $('#{{ $id }} table > tfoot select.repeat-key').val();
            if (specificationSet.hasOwnProperty(specification)) {
                var options = specificationSet[specification];
                for (var key in options) {
                    if (options.hasOwnProperty(key) && options[key].hasOwnProperty('title')) {
                        $('#{{ $id }} table > tfoot select.repeat-value').append('<option value="' + key + '">' + options[key].title + '</option>');
                    }
                }
            }
            $('#{{ $id }} table > tfoot select.repeat-value').selectpicker('refresh');
            if ($('#{{ $id }} table > tfoot select.repeat-value option:not([value=""])').length > 0) {
                $('#{{ $id }} table > tfoot select.repeat-value').prop('disabled', false).selectpicker('refresh');
            }
        }

        $('#{{ $id }}')
            .on('change', 'select.repeat-key', function () {
                refreshSpecificationItems();
            })
            .on('click', '.repeat-add', function () {
                var specificationValue = $('#{{ $id }} table > tfoot select.repeat-key').val();
                var specificationLabel = $('#{{ $id }} table > tfoot select.repeat-key > option:selected').text();
                var optionValue = $('#{{ $id }} table > tfoot select.repeat-value').val();
                var optionLable = $('#{{ $id }} table > tfoot select.repeat-value > option:selected').text();

                if (specificationValue !== '' && optionValue !== '') {
                    $('#{{ $id }} table > tbody').append(
                        $('#template-{{ $id }}').html()
                            .replace(/DUMP_SPEC/ig, specificationLabel)
                            .replace(/DUMP_LABEL/ig, optionLable)
                            .replace(/DUMP_VALUE/ig, optionValue)
                    );
                    refreshSpecificationList();
                }
            })
            .on('click', '.repeat-remove', function () {
                $(this).parents('tr').remove();
                refreshSpecificationList();
            });
    });
})(jQuery);
</script>
@endpush