<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::admin.layouts.breadcrumbs', 'create'))

@section('content')
<!-- layout-content-->
<div class="row">
    <div class="col-xl-6">
        <section class="panel panel-default">
            <header class="panel-heading">
                <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('MinmaxBase::admin.form.create')</h1>

                @yield('action-buttons')
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    <form id="createForm" class="form-horizontal validate createForm"  name="createForm"
                          action="{{ langRoute("admin.{$pageData->uri}.store") }}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf

                        @yield('forms')
                    </form>
                </div>
            </div>
        </section>
    </div>
    <div class="col-xl-6">
        <section class="panel panel-default">
            <header class="panel-heading">
                <h1 class="h5 float-left font-weight-bold">@lang('MinmaxBase::admin.form.note')</h1>
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    @yield('notes')
                </div>
            </div>
        </section>
    </div>
</div>
<!-- / layout-content-->
@endsection