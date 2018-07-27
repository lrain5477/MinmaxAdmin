<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>

    <div class="col-sm-10">
        <input type="hidden" name="{{ $name }}[path]" value="{{ $path }}">
        <input type="hidden" id="{{ $id }}-origin" name="{{ $name }}[origin]" value="{{ $file }}">
        <div class="custom-file">
            <input class="custom-file-input" name="{{ $name }}[file][]" type="file" id="{{ $id }}" {!! $required === true ? 'required' : '' !!} multiple>
            <label class="custom-file-label" id="{{ $id }}-label" for="{{ $id }}">{{ $filename == '' ? __('admin.form.file.default_text') : $filename }}</label>
        </div>
        @if($filename != '')
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="{{ $id }}-remove" />
            <label class="custom-control-label" for="{{ $id }}-remove">@lang('admin.form.file.remove_file')</label>
        </div>
        @endif
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>

@push('scripts')
<script>
(function($) {
    $(function() {
        $('#{{ $id }}').on('change', function() {
            var limit = parseInt('{{ $limit }}');
            if(limit > 0 && this.files.length > limit) {
                this.value = '';
                $('#{{ $id }}-label').text('{{ $filename == '' ? __('admin.form.file.default_text') : $filename }}');
                swal('@lang('admin.form.file.limit_title')', '@lang('admin.form.file.limit_text', ['limit' => $limit])');
            } else {
                var nameList = '';
                for(var i = 0; i < this.files.length; i++) {
                    nameList += this.files[i] ? ((nameList === '' ? '' : ', ') + this.files[i].name) : '';
                }
                $('#{{ $id }}-label').text(nameList === '' ? '@lang('admin.form.file.default_text')' : nameList);
            }
        });
        @if($filename != '')
        $('#{{ $id }}-remove').on('change', function() {
            if($(this).prop('checked')) {
                $('#{{ $id }}-origin').val('');
                $('#{{ $id }}-label').text('@lang('admin.form.file.default_text')');
            } else {
                $('#{{ $id }}-origin').val('{{ $file }}');
                $('#{{ $id }}-label').text('{{ $filename }}');
            }
        });
        @endif
    });
})(jQuery);
</script>
@endpush