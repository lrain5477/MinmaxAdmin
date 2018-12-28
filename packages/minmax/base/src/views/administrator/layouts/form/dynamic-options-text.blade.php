<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 * @var array $values
 *
 * Options
 * @var boolean $required
 * @var integer $size
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">
        @if($language)<i class="icon-globe"></i>@endif
        {{ $label }}<!--
        @if($required)--><span class="text-danger ml-1">*</span><!--@endif
        -->
    </label>
    <div class="col-sm-{{ $size }}" id="{{ $id }}">
        <div class="w-100">
            @foreach($values as $key => $value)
            <div class="form-row mb-2">
                <div class="col-3">
                    <input class="form-control repeat-key" type="text" placeholder="Key" data-column-name="{{ $name }}"
                           value="{{ $key }}" {{ $required ? 'required' : '' }} />
                </div>
                <div class="col-6">
                    <input type="text" class="form-control repeat-value" name="{{ $name }}[{{ $key }}]" value="{{ $value }}" placeholder="Value" />
                </div>
                <div class="col-auto">
                    <button class="btn btn-danger repeat-remove" type="button"><i class="icon-cross"></i></button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary btn-sm repeat-add"><i class="icon-plus"></i></button>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>

<template id="template-{{ $id }}">
    <div class="form-row mb-2" style="display: none;">
        <div class="col-3">
            <input class="form-control repeat-key" type="text" placeholder="Key" data-column-name="{{ $name }}" value="" {{ $required ? 'required' : '' }} />
        </div>
        <div class="col-6">
            <input type="text" class="form-control repeat-value" value="" placeholder="Value" />
        </div>
        <div class="col-auto">
            <button class="btn btn-danger repeat-remove" type="button"><i class="icon-cross"></i></button>
        </div>
    </div>
</template>

@push('scripts')
<script>
(function ($) {
    $(function () {
        $('#{{ $id }}')
            .on('click', '.repeat-add', function () {
                $('#{{ $id }} > div').append($('#template-{{ $id }}').html());
                $('#{{ $id }} > div > .form-row:last').slideDown();
            })
            .on('click', '.repeat-remove', function () {
                $(this).parents('.form-row').remove();
                @if($required)
                if($('#{{ $id }} > div > .form-row').length < 1) {
                    $('#{{ $id }} .repeat-add').click();
                }
                @endif
            })
            .on('keyup', '.repeat-key', function() {
                var $this = $(this);
                var $item = $this.parents('.form-row');
                $item.find('.repeat-value').attr('name', $this.attr('data-column-name') + '[' + $this.val() + ']');
            });
        @if($required && count($values) < 1)
        $('#{{ $id }} .repeat-add').click();
        @endif
    });
})(jQuery);
</script>
@endpush