<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 * @var string $value
 *
 * Options
 * @var boolean $required
 * @var integer $size
 * @var string $height
 * @var string $stylesheet
 * @var string|null $template
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
    <div class="col-sm-{{ $size }}">
        <textarea class="form-control"
                  id="{{ $id }}"
                  name="{{ $name }}"
                  {{ $required === true ? 'required' : '' }} >{{ old(str_replace(['[', ']'], ['.', ''], $name), $value) }}</textarea>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>

@push('scripts')
<script>
(function($) {
    $(function() {
        CKEDITOR.replace('{{ $id }}', {
            customConfig: 'admin-config.js',
            height: '{{ $height }}',
            contentsCss: '{{ $stylesheet }}',
            @if($template)
            templates_files: ['{{ langRoute('administrator.editorTemplate', [$template]) }}'],
            @else
            removeButtons: 'Templates',
            @endif
            filebrowserBrowseUrl: '{{ langRoute('administrator.elfinder.ckeditor') }}'
        });
        CKEDITOR.dtd.$removeEmpty['i'] = 0;
        CKEDITOR.dtd.$removeEmpty['span'] = 0;
    });
})(jQuery);
</script>
@endpush