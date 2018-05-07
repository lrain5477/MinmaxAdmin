<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-{{ $size }}">
        <textarea class="form-control"
                  id="{{ $id }}"
                  name="{{ $name }}"
                  {{ $required === true ? 'required' : '' }} >{{ old($name, $value) }}</textarea>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>

@push('scripts')
<script>
(function($) {
    $(function() {
        CKEDITOR.replace('{{ $id }}', {customConfig: 'config.js', width: '100%', height: '{{ $height }}', filebrowserBrowseUrl: '/siteadmin/elfinder/ckeditor'});
        CKEDITOR.dtd.$removeEmpty['i'] = false;
    });
})(jQuery);
</script>
@endpush