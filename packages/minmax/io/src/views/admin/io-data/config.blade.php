<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Io\Models\IoConstruct $formData
 */
?>

@extends('MinmaxBase::admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::admin.layouts.breadcrumbs', 'config'))

@section('content')
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $formData->title }}</h1>

        <div class="float-right">
            <a class="btn btn-sm btn-light" href="{{ langRoute("admin.{$pageData->uri}.index") }}" title="@lang('MinmaxBase::admin.grid.back')">
                <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.grid.back')</span>
            </a>
        </div>
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <header class="mb-4">
                <ul class="nav nav-tabs" id="ioTab" role="tablist">
                    @if($formData->import_enable)
                    <li class="nav-item">
                        <a class="nav-link {{ request('method', 'import') == 'import' ? 'active' : '' }}"
                           id="tab-import" data-toggle="tab"
                           href="#tab-pane-import" role="tab"
                           onclick="window.history.pushState(null, null, '?method=import')"
                           aria-controls="tab-pane-import" aria-selected="true">@lang('MinmaxIo::admin.form.import')</a>
                    </li>
                    @endif
                    @if($formData->export_enable)
                    <li class="nav-item">
                        <a class="nav-link {{ request('method', 'import') == 'export' ? 'active' : ($formData->import_enable ? '' : 'active') }}"
                           id="tab-export" data-toggle="tab"
                           href="#tab-pane-export" role="tab"
                           onclick="window.history.pushState(null, null, '?method=export')"
                           aria-controls="tab-pane-export" aria-selected="true">@lang('MinmaxIo::admin.form.export')</a>
                    </li>
                    @endif
                </ul>
            </header>
            <div class="tab-content" id="myTabContent">
                @if($formData->import_enable && ! is_null($formData->import_view))
                <div class="tab-pane fade {{ request('method', 'import') == 'import' ? 'show active' : '' }}"
                     id="tab-pane-import" role="tabpanel" aria-labelledby="tab-import">
                    @include($formData->import_view)
                </div>
                @endif
                @if($formData->export_enable && ! is_null($formData->export_view))
                <div class="tab-pane fade {{ request('method', 'import') == 'export' ? 'show active' : ($formData->import_enable ? '' : 'show active') }}"
                     id="tab-pane-export" role="tabpanel" aria-labelledby="tab-export">
                    @include($formData->export_view)
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
