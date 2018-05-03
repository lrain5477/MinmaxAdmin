<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-{{ $size }}">
        @if($icon === '')
        <input type="tel" class="form-control"
               id="{{ $id }}"
               name="{{ $name }}"
               value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}"
               {{ $required === true ? 'required' : '' }} />
        @else
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="{{ $icon }}"></i></span>
            </div>
            <input type="tel" class="form-control"
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value="{{ old($name, $value) }}"
                   placeholder="{{ $placeholder }}"
                   {{ $required === true ? 'required' : '' }} />
        </div>
        @endif
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>