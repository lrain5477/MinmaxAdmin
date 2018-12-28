<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 * @var string $file
 * @var string $filename
 *
 * Options
 * @var boolean $required
 * @var string $path
 * @var integer $limit
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

    <div class="col-sm-10">
        <input type="hidden" name="{{ $name }}[path]" value="{{ $path }}">
        <input type="hidden" id="{{ $id }}-origin" name="{{ $name }}[origin]" value="{{ $file }}">
        <div class="custom-file">
            <input class="custom-file-input" name="{{ $name }}[file][]" type="file" id="{{ $id }}" {!! $required === true ? 'required' : '' !!} multiple>
            <label class="custom-file-label" id="{{ $id }}-label" for="{{ $id }}">{{ $filename == '' ? __('MinmaxBase::administrator.form.file.default_text') : $filename }}</label>
        </div>
        @if($filename != '')
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="{{ $id }}-remove" />
            <label class="custom-control-label" for="{{ $id }}-remove">@lang('MinmaxBase::administrator.form.file.remove_file')</label>
        </div>
        @endif
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>
@if($file != '')
<div class="form-group row" id="{{ $id }}-list">
    <div class="col-sm-10 offset-sm-2">
        <div class="file-list">
            @foreach(explode(', ', $file) as $fileItem)
            <div class="alert alert-info alert-dismissible fade show ui-sortable-handle" role="alert">
                {{ $fileItem }} <a href="{{ asset($fileItem) }}" class="alert-link" target="_blank"><i class="icon-popout"></i></a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
(function($) {
    $(function() {
        $('#{{ $id }}').on('change', function() {
            var limit = parseInt('{{ $limit }}');
            if(limit > 0 && this.files.length > limit) {
                this.value = '';
                $('#{{ $id }}-label').text('{{ $filename == '' ? __('MinmaxBase::administrator.form.file.default_text') : $filename }}');
                swal('@lang('MinmaxBase::administrator.form.file.limit_title')', '@lang('MinmaxBase::administrator.form.file.limit_text', ['limit' => $limit])');
            } else {
                var nameList = '';
                for(var i = 0; i < this.files.length; i++) {
                    nameList += this.files[i] ? ((nameList === '' ? '' : ', ') + this.files[i].name) : '';
                }
                $('#{{ $id }}-label').text(nameList === '' ? '@lang('MinmaxBase::administrator.form.file.default_text')' : nameList);
            }
        });
        @if($filename != '')
        $('#{{ $id }}-remove').on('change', function() {
            if($(this).prop('checked')) {
                $('#{{ $id }}-origin').val('');
                $('#{{ $id }}-label').text('@lang('MinmaxBase::administrator.form.file.default_text')');
                $('#{{ $id }}-list').hide();
            } else {
                $('#{{ $id }}-origin').val('{{ $file }}');
                $('#{{ $id }}-label').text('{{ $filename }}');
                $('#{{ $id }}-list').show();
            }
        });
        @endif
    });
})(jQuery);
</script>
@endpush