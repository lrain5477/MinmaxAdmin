<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var string $values
 * @var array $listData
 *
 * Options
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-10">
        <select id="{{ $id }}" name="{{ $name }}" multiple></select>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>

@push('scripts')
<script>
(function ($) {
    $(function () {
        var parameters_{{ str_replace('-', '_', $id) }} = JSON.parse("{!! addslashes(json_encode(array_pluck($listData, 'title'))) !!}");

        $('#{{ $id }}').tagsinput({
            typeaheadjs: {
                name: '{{ $id }}',
                source: substringMatcher(parameters_{{ str_replace('-', '_', $id) }}),
            }
        });
        @foreach($values as $value)
        @if(array_key_exists($value, $listData))
        $('#{{ $id }}').tagsinput('add', '{{ $listData[$value]['title'] ?? '' }}');
        @endif
        @endforeach
    });
})(jQuery);
</script>
@endpush
