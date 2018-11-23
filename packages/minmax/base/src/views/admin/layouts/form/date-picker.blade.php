<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-xl-{{ $size }}">
            <input type="text" class="form-control datepicker-{{ $type }}" style="padding-left: 32px;"
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value="{{ old($name, $value) }}"
                   placeholder="{{ $placeholder }}"
                   {{ $required === true ? 'required' : '' }} />
            <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>