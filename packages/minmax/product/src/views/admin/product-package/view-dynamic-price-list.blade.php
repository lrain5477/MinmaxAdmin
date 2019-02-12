<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var array $currencies
 * @var array $values
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-10" id="{{ $id }}">
        <table class="table table-sm table-bordered mb-1">
            <thead class="thead-default">
            <tr class="text-center">
                <th>@lang("MinmaxProduct::admin.form.{$name}.currency")</th>
                <th>@lang("MinmaxProduct::models.{$name}.price_advice")</th>
                <th>@lang("MinmaxProduct::models.{$name}.price_sell")</th>
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
                </td>
                <td>
                    {{ array_get($value, 'sell') }}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>