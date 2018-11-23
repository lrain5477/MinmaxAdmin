<?php
/**
 * @var $breadcrumbs
 */
?>
@if (count($breadcrumbs))
<nav class="breadcrumb ml-2 mt-1">
@foreach ($breadcrumbs as $breadcrumb)
    @if ($breadcrumb->url && !$loop->last)
        @if ($breadcrumb->title == __('MinmaxBase::admin.breadcrumbs.home'))
        <a class="breadcrumb-item" href="{{ $breadcrumb->url }}"><i class="icon-home3 mr-2"></i><span>{{ $breadcrumb->title }}</span></a>
        @else
        <a class="breadcrumb-item" href="{{ $breadcrumb->url }}"><span>{{ $breadcrumb->title }}</span></a>
        @endif
    @else
        @if ($breadcrumb->title == __('MinmaxBase::admin.breadcrumbs.home'))
        <span class="breadcrumb-item active"><i class="icon-home3 mr-2"></i>{{ $breadcrumb->title }}</span>
        @else
            @if (!$loop->last)
            <span class="breadcrumb-item">{{ $breadcrumb->title }}</span>
            @else
                @if ($breadcrumb->title == __('MinmaxBase::admin.breadcrumbs.home'))
                <span class="breadcrumb-item active"><i class="icon-home3 mr-2"></i>{{ $breadcrumb->title }}</span>
                @else
                <span class="breadcrumb-item active">{{ $breadcrumb->title }}</span>
                @endif
            @endif
        @endif
    @endif
@endforeach
</nav>
@endif