<?php
/**
 * @var \App\Models\AdministratorMenu $pageData
 * @var integer|string $formDataId
 */
?>

@extends('administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('administrator.layouts.breadcrumbs', 'edit'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('administrator.form.edit')</h1>

        @yield('action-buttons')
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="editForm" class="form-horizontal validate editForm" name="editForm"
                  action="{{ langRoute("administrator.{$pageData->uri}.update", [$formDataId]) }}"
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