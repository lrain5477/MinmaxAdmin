<?php
/**
 * @var \App\Models\AdminMenu $pageData
 * @var integer|string $formDataId
 */
?>

@extends('admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('admin.layouts.breadcrumbs', 'edit'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('admin.form.edit')</h1>

        @yield('action-buttons')
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="editForm" class="form-horizontal validate editForm"  name="editForm"
                  action="{{ langRoute("admin.{$pageData->uri}.update", [$formDataId]) }}"
                  method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                @yield('forms')
            </form>
        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection