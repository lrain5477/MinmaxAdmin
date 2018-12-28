<?php
/**
 * @var \Illuminate\Support\Collection $breadcrumbs
 */
?>
@if (count($breadcrumbs) > 0)
<nav class="breadcrumb mb-0 pl-1">
@foreach ($breadcrumbs as $breadcrumb)
    @if ($loop->first)
    <span class="align-middle"><i class="icon-folder-open i-o h4 mb-0 p-0 mr-1"></i></span>
    @endif

    @if ($breadcrumb->url)
    <a class="breadcrumb-item" href="{{ $breadcrumb->url }}"><span>{{ $breadcrumb->title }}</span></a>
    @else
    <span class="breadcrumb-item">{{ $breadcrumb->title }}</span>
    @endif
@endforeach
</nav>
@endif