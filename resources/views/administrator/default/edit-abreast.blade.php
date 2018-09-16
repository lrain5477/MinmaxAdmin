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
<div class="row">
    <div class="col-xl-6">
        <section class="panel panel-default">
            <header class="panel-heading">
                <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('administrator.form.edit')</h1>

                @yield('action-buttons')
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    <form id="editForm" class="form-horizontal validate editForm"  name="editForm"
                          action="{{ langRoute("administrator.{$pageData->uri}.update", [$formData->guid]) }}"
                          method="post"
                          enctype="multipart/form-data">
                        @method('PUT')
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
                <h1 class="h5 float-left font-weight-bold">@lang('administrator.form.record')</h1>
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    @yield('records')
                </div>
            </div>
        </section>
    </div>
</div>
<!-- / layout-content-->
@endsection