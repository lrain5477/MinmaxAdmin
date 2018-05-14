<?php
/**
 * @var string $value
 * @var string $alt
 * @var integer $size
 */
?>
<a class="thumb" href="{{ asset($value) }}" data-fancybox="" data-caption="{{ $alt }}">
    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"
          style="background: url('{{ route('administrator.thumbnail', ['width' => $size, 'height' => $size, 'imagePath' => $value]) }}') center center no-repeat; background-size: cover;">
        <img src="{{ route('administrator.thumbnail', ['width' => $size, 'height' => $size, 'imagePath' => $value]) }}" alt="{{ $alt }}" style="display: none;">
    </span>
</a>