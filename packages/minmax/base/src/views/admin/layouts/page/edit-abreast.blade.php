<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var integer|string $formDataId
 */
?>

@extends('MinmaxBase::admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::admin.layouts.breadcrumbs', 'edit'))

@section('content')
<div class="row">
    <div class="col-xl-6">
        <section class="panel panel-default">
            <header class="panel-heading">
                <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('MinmaxBase::admin.form.edit')</h1>

                @yield('action-buttons')
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    <form id="editForm" class="form-horizontal validate editForm"  name="editForm"
                          action="{{ langRoute("admin.{$pageData->uri}.update", ['id' => $formDataId]) }}"
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
                <h1 class="h5 float-left font-weight-bold">@lang('MinmaxBase::admin.form.record')</h1>
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    @yield('records')
                </div>
            </div>
        </section>
    </div>
</div>
@endsection