<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-10">
        @if($plaintText === true)
        <input type="text" class="form-control-plaintext" id="{{ $id }}" value="{{ $value }}" readonly />
        @else
        <div class="form-text" id="{{ $id }}">{{ $value }}</div>
        @endif
    </div>
</div>