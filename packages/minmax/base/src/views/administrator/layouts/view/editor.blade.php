<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $value
 *
 * Options
 * @var integer $size
 * @var string $height
 * @var string $stylesheet
 */
?>
<div class="form-group row {{ $language ? 'len' : '' }}">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-{{ $size }}">
        <textarea class="form-control" id="{{ $id }}">{{ $value }}</textarea>
    </div>
</div>

@push('scripts')
<script>
(function($) {
    $(function() {
        CKEDITOR.replace('{{ $id }}', {
            customConfig: 'admin-config.js',
            height: '{{ $height }}',
            readOnly: true,
            resize_enabled:false,
            contentsCss: '{{ $stylesheet }}'
        });
        CKEDITOR.dtd.$removeEmpty['i'] = 0;
        CKEDITOR.dtd.$removeEmpty['span'] = 0;
    });
})(jQuery);
</script>
@endpush