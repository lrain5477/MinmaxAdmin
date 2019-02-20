<?php
/**
 * @var \Illuminate\Support\Collection $breadcrumbs
 */
?>
@if (count($breadcrumbs) > 0)
<ol class="breadcrumb p-1">
@foreach ($breadcrumbs as $breadcrumb)
    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}"><!--
    @if ($loop->last || !isset($breadcrumb->url))
        @if ($loop->first)
        --><i class="icon-folder-open mr-2"></i><!--
        @endif
        --><span>{{ $breadcrumb->title }}</span>
    @else
        --><a href="{{ $breadcrumb->url }}"><!--
            @if ($loop->first)
            --><i class="icon-folder-open mr-2"></i><!--
            @endif
            --><span>{{ $breadcrumb->title }}</span>
        </a>
    @endif
    </li>
@endforeach
</ol>
@endif