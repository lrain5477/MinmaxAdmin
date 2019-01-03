<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 */
?>
@extends('MinmaxBase::admin.layouts.site')
{{-- Set breadcrimbs --}}
{{--@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::admin.layouts.breadcrumbs', 'admin.home'))--}}

@section('content')
{{-- Page Content --}}
@endsection

@push('scripts')
{{-- Custom Page Javascript --}}
@endpush