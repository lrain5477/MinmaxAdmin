<?php
/**
 * @var \App\Models\AdministratorMenu $pageData
 */
?>

@extends('administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('administrator.layouts.breadcrumbs', 'create'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('administrator.form.create')</h1>

        @yield('action-buttons')
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="createForm" class="form-horizontal validate createForm"  name="createForm"
                  action="{{ langRoute("administrator.{$pageData->uri}.store") }}"
                  method="post"
                  enctype="multipart/form-data">
                @csrf

                @yield('forms')
            </form>
        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection