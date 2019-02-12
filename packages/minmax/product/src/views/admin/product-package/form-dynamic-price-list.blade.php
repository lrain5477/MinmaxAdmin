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
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}<span class="text-danger ml-1">*</span></label>
    <div class="col-sm-10" id="{{ $id }}">
        <table class="table table-sm table-bordered mb-1">
            <thead class="thead-default">
            <tr class="text-center">
                <th>@lang("MinmaxProduct::admin.form.{$name}.currency")</th>
                <th>@lang("MinmaxProduct::models.{$name}.price_advice")</th>
                <th>@lang("MinmaxProduct::models.{$name}.price_sell")</th>
                <th>@lang("MinmaxProduct::admin.form.{$name}.actions")</th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach($values as $key => $value)
            <tr>
                <td>
                    {{ array_get($currencies, "{$key}.title") }}
                </td>
                <td>
                    {{ array_get($value, 'advice') }}
                    <input type="hidden" name="{{ $name }}[price_advice][{{ $key }}]" value="{{ array_get($value, 'advice') }}" />
                </td>
                <td>
                    {{ array_get($value, 'sell') }}
                    <input type="hidden" name="{{ $name }}[price_sell][{{ $key }}]" value="{{ array_get($value, 'sell') }}" />
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
                        <option value="">@lang("MinmaxProduct::admin.form.{$name}.please_select")</option>
                        @foreach ($currencies as $key => $currency)
                        <option value="{{ $key }}" {{ array_key_exists($key, $values) ? 'disabled' : '' }}>{{ $currency['title'] ?? '' }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input class="form-control form-control-sm repeat-advice" type="text" /></td>
                <td><input class="form-control form-control-sm repeat-sell" type="text" /></td>
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
        <td>DUMP_ADVICE<input type="hidden" name="{{ $name }}[price_advice][DUMP_CURRENCY_KEY]" value="DUMP_ADVICE" /></td>
        <td>DUMP_SELL<input type="hidden" name="{{ $name }}[price_sell][DUMP_CURRENCY_KEY]" value="DUMP_SELL" /></td>
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
            $('#{{ $id }} table > tbody input[name^="{{ $name }}[price_advice]"]').each(function() {
                var $this = $(this);
                var currency = $this.attr('name').replace(/^ProductPackage\[price_advice]\[/i, '').replace(/]$/i, '');
                $('#{{ $id }} table > tfoot .repeat-key option[value="' + currency + '"]').prop('disabled', true);
            });
            $('#{{ $id }} table > tfoot .repeat-key').selectpicker('refresh');
            $('#{{ $id }} table > tfoot .repeat-key').selectpicker('val', '');
            $('#{{ $id }} table > tfoot .repeat-advice').val('');
            $('#{{ $id }} table > tfoot .repeat-sell').val('');
        }

        $('#{{ $id }}')
            .on('click', '.repeat-add', function () {
                var currency = $('#{{ $id }} table > tfoot .repeat-key > option:selected').val();
                var currencyLabel = $('#{{ $id }} table > tfoot .repeat-key > option:selected').text();
                var advice = $('#{{ $id }} table > tfoot .repeat-advice').val();
                var sell = $('#{{ $id }} table > tfoot .repeat-sell').val();

                if (currency !== '' && advice !== '' && sell !== '') {
                    $('#{{ $id }} table > tbody').append(
                        $('#template-{{ $id }}').html()
                            .replace(/DUMP_CURRENCY_LABEL/ig, currencyLabel)
                            .replace(/DUMP_CURRENCY_KEY/ig, currency)
                            .replace(/DUMP_ADVICE/ig, advice)
                            .replace(/DUMP_SELL/ig, sell)
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