<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 */
?>
@extends('MinmaxBase::administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::administrator.layouts.breadcrumbs', 'administrator.home'))

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
            <section class="panel">
                <header class="panel-heading mb-2">
                    <h2 class="h5">#TITLE</h2>
                </header>
                <div class="panel-body px-0 pt-0 pb-2">
                    #CONTENT
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
            <section class="panel">
                <header class="panel-heading text-center">
                    <h2 class="h5 px-2">#TITLE</h2>
                </header>
                <div class="panel-body px-0 py-0">
                    #CONTENT
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading text-center">
                    <h2 class="h5">#TITLE</h2>
                </header>
                <div class="panel-body px-0 py-0">
                    #CONTENT
                </div>
            </section>
        </div>
        <div class="col-xl-6 col-xs-12">
            <section class="panel">
                <header class="panel-heading mb-2">
                    <h2 class="h5">#TITLE</h2>
                </header>
                <div class="panel-body px-0 pt-0 pb-2">
                    #CONTENT
                </div>
            </section>
        </div>
    </div>
    <div class="row text-center mt-3">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <section class="panel p-3 bg-danger text-white">
                <div class="row">
                    <div class="col"><span class="d-block mb-1 h3">0</span><span class="d-block">#TOPIC</span></div>
                    <div class="col"><span class="icon-accessibility display-4"></span></div>
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <section class="panel p-3 bg-warning text-white">
                <div class="row">
                    <div class="col"><span class="d-block mb-1 h3">0</span><span class="d-block">#TOPIC</span></div>
                    <div class="col"><span class="icon-mail-envelope-open display-4"></span></div>
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <section class="panel p-3 bg-info text-white">
                <div class="row">
                    <div class="col"><span class="d-block mb-1 h3">0</span><span class="d-block">#TOPIC</span></div>
                    <div class="col"><span class="icon-mail-envelope-open display-4"></span></div>
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <section class="panel p-3 bg-success text-white">
                <div class="row">
                    <div class="col"><span class="d-block mb-1 h3">0</span><span class="d-block">#TOPIC</span></div>
                    <div class="col"><span class="icon-shopping-cart display-4"></span></div>
                </div>
            </section>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-6 col-lg-12">
            <section class="panel">
                <header class="panel-heading mb-2">
                    <h2 class="h5 float-left">#TITLE</h2>
                    <div class="float-right"><a class="btn btn-danger btn-sm mr-15" href="#">#LINK</a></div>
                </header>
                <div class="panel-wrapper">
                    <div class="panel-body" style="min-height:270px;">
                        #CONTENT
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xl-6 col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="h5 float-left">#TITLE</h2>
                </header>
                <div class="panel-wrapper"></div>
                <div class="panel-body" style="min-height:270px;">
                    #CONTENT
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- * * * ammap 分析統計圖 --}}
<script src="{{ asset('static/modules/amcharts/ammap.js') }}"></script>
<script src="{{ asset('static/modules/amcharts/maps/js/worldLow.js') }}"></script>
{{-- * * * amcharts 分析統計圖 --}}
<script src="{{ asset('static/modules/amcharts/amcharts.js') }}"></script>
<script src="{{ asset('static/modules/amcharts/pie.js') }}"></script>
<script src="{{ asset('static/modules/amcharts/serial.js') }}"></script>
<script src="{{ asset('static/modules/amcharts/plugins/export/export.min.js') }}"></script>
<script src="{{ asset('static/modules/amcharts/plugins/dataloader/dataloader.min.js') }}"></script>
<script src="{{ asset('static/modules/amcharts/themes/light.js') }}"></script>
<script src="{{ asset('static/modules/amcharts/lib/amstock.js') }}"></script>
{{-- page index
<script src="{{ asset('static/admin/js/index.js') }}"></script>--}}
@endpush