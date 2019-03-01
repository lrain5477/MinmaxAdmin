<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var array $currencies
 * @var array $values
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
                <th>@lang("MinmaxProduct::administrator.form.{$name}.currency")</th>
                <th>@lang("MinmaxProduct::models.{$name}.cost")</th>
                <th>@lang("MinmaxProduct::models.{$name}.price")</th>
                <th>@lang("MinmaxProduct::administrator.form.{$name}.actions")</th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach($values as $key => $value)
            <tr>
                <td>
                    {{ array_get($currencies, "{$key}.title") }}
                </td>
                <td>
                    {{ array_get($value, 'cost') }}
                    <input type="hidden" name="{{ $name }}[cost][{{ $key }}]" value="{{ array_get($value, 'cost') }}" />
                </td>
                <td>
                    {{ array_get($value, 'price') }}
                    <input type="hidden" name="{{ $name }}[price][{{ $key }}]" value="{{ array_get($value, 'price') }}" />
                </td>
                <td class="text-center text-nowrap">
                    <button class="btn btn-danger btn-sm repeat-remove" type="button"><i class="icon-cross"></i></button>
                </td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td class="text-center">
                    <select class="form-control bs-select repeat-key" data-style="btn-outline-light btn-sm">
                        <option value="">@lang("MinmaxProduct::administrator.form.{$name}.please_select")</option>
                        @foreach ($currencies as $key => $currency)
                        <option value="{{ $key }}" {{ array_key_exists($key, $values) ? 'disabled' : '' }}>{{ $currency['title'] ?? '' }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input class="form-control form-control-sm repeat-cost" type="text" /></td>
                <td><input class="form-control form-control-sm repeat-price" type="text" /></td>
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
        <td>DUMP_CURRENCY_LABEL</td>
        <td>DUMP_COST<input type="hidden" name="{{ $name }}[cost][DUMP_CURRENCY_KEY]" value="DUMP_COST" /></td>
        <td>DUMP_PRICE<input type="hidden" name="{{ $name }}[price][DUMP_CURRENCY_KEY]" value="DUMP_PRICE" /></td>
        <td class="text-center text-nowrap">
            <button class="btn btn-danger btn-sm repeat-remove" type="button"><i class="icon-cross"></i></button>
        </td>
    </tr>
</template>

@push('scripts')
<script>
(function ($) {
    $(function () {
        function reflashCurrencyList() {
            $('#{{ $id }} table > tfoot .repeat-key option').prop('disabled', false);
            $('#{{ $id }} table > tbody input[name^="{{ $name }}[cost]"]').each(function() {
                var $this = $(this);
                var currency = $this.attr('name').replace(/^ProductItem\[cost]\[/i, '').replace(/]$/i, '');
                $('#{{ $id }} table > tfoot .repeat-key option[value="' + currency + '"]').prop('disabled', true);
            });
            $('#{{ $id }} table > tfoot .repeat-key').selectpicker('refresh');
            $('#{{ $id }} table > tfoot .repeat-key').selectpicker('val', '');
            $('#{{ $id }} table > tfoot .repeat-cost').val('');
            $('#{{ $id }} table > tfoot .repeat-price').val('');
        }

        $('#{{ $id }}')
            .on('click', '.repeat-add', function () {
                var currency = $('#{{ $id }} table > tfoot .repeat-key > option:selected').val();
                var currencyLabel = $('#{{ $id }} table > tfoot .repeat-key > option:selected').text();
                var cost = $('#{{ $id }} table > tfoot .repeat-cost').val();
                var price = $('#{{ $id }} table > tfoot .repeat-price').val();

                if (currency !== '' && cost !== '' && price !== '') {
                    $('#{{ $id }} table > tbody').append(
                        $('#template-{{ $id }}').html()
                            .replace(/DUMP_CURRENCY_LABEL/ig, currencyLabel)
                            .replace(/DUMP_CURRENCY_KEY/ig, currency)
                            .replace(/DUMP_COST/ig, cost)
                            .replace(/DUMP_PRICE/ig, price)
                    );
                    reflashCurrencyList();
                }
            })
            .on('click', '.repeat-remove', function () {
                $(this).parents('tr').remove();
                reflashCurrencyList();
            });
    });
})(jQuery);
</script>
@endpush