<?php
/**
 * @var string $value
 * @var string $alt
 * @var integer $size
 */
?>
@if(!is_null($value) && $value !== '' && File::exists(public_path($value)))
<a class="thumb" href="{{ asset($value) }}" data-fancybox="" data-caption="{{ $alt }}">
    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"
          style="background: url('{{ getThumbnailPath($value, $size, false) }}') center center no-repeat; background-size: cover;">
        <img src="{{ getThumbnailPath($value, $size, false) }}" alt="{{ $alt }}" style="display: none;">
    </span>
</a>
@else
<div class="thumb">
    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"
          style="background: url('{{ asset('static/admin/images/common/noimage.gif') }}') center center no-repeat; background-size: cover;">
        <img src="{{ asset('static/admin/images/common/noimage.gif') }}" alt="" style="display: none;">
    </span>
</div>
@endif