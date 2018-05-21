<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-{{ $size }}">
        <textarea class="form-control" id="{{ $id }}">{{ $value }}</textarea>
    </div>
</div>

@push('scripts')
<script>
(function($) {
    $(function() {
        CKEDITOR.replace('{{ $id }}', {customConfig: 'config.js', width: '100%', height: '250px', toolbar:[{ name: 'document', items: [ 'Source']}], resize_enabled:false, removePlugins: 'elementspath', contentsCss: '{{ $stylesheet }}'});
        CKEDITOR.dtd.$removeEmpty['i'] = false;
    });
})(jQuery);
</script>
@endpush