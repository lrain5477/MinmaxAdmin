@extends('administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')
<div class="content-body">
    <!-- layout-content-->
    <!-- row  -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
            <section class="panel">
                <header class="panel-heading mb-2">
                    <h2 class="h5">流量來源</h2>
                </header>
                <div class="panel-body px-0 pt-0 pb-2">
                    <div id="analyticsTraffic" style="width: 100%; height:195px;"></div>
                    <div class="row pl-3 pr-1">
                        <div class="col-sm-8 col-xs-12"><span class="badge badge-info float-left clabels d-inline mt-1 mr-3 no-radius"></span>
                            <div class="clabels-text d-inline txt-dark text-capitalize float-left"><span class="d-block font-weight-bold mb-1">44.46%  搜索</span><span class="d-block text-muted small">85 訪問</span></div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="float-right mb-1" id="traffic1" style="width: 100%; height:30px;"></div>
                        </div>
                    </div>
                    <hr class="my-2 w-100">
                    <div class="row pl-3 pr-1">
                        <div class="col-sm-8 col-xs-12"><span class="badge badge-warning float-left clabels d-inline mt-1 mr-3 no-radius"></span>
                            <div class="clabels-text d-inline txt-dark text-capitalize float-left"><span class="d-block font-weight-bold mb-1">32.1%  直接</span><span class="d-block text-muted small">68 訪問</span></div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="float-right mb-1" id="traffic2" style="width: 100%; height:30px;"></div>
                        </div>
                    </div>
                    <hr class="my-2 w-100">
                    <div class="row pl-3 pr-1">
                        <div class="col-sm-8 col-xs-12"><span class="badge badge-success float-left clabels d-inline mt-1 mr-3 no-radius"></span>
                            <div class="clabels-text d-inline txt-dark text-capitalize float-left"><span class="d-block font-weight-bold mb-1">27.8%  推薦</span><span class="d-block text-muted small">59 訪問</span></div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="float-right mb-1" id="traffic3" style="width: 100%; height:30px;"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
            <section class="panel">
                <header class="panel-heading text-center">
                    <h2 class="h5 px-2">線上使用者</h2>
                </header>
                <div class="panel-body px-0 py-0">
                    <div class="h1 text-center font-weight-bold pb-2"><span class="text-danger">{{ $currentVisitor }}</span></div>
                    <div class="progress" title="73.77% 新工作階段">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 73.77%; height:5px;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row text-center py-3">
                        <div class="col"><span class="d-block text-muted small">單次頁數</span><span class="d-block font-weight-bold mb-1">{{ $pageViewsPerSession }}</span></div>
                        <div class="col"><span class="d-block text-muted small">停留時間</span><span class="d-block font-weight-bold mb-1">{{ $avgTimeOnPage }}</span></div>
                        <div class="col"><span class="d-block text-muted small">跳出率</span><span class="d-block font-weight-bold mb-1">{{ $exitRate }}%</span></div>
                    </div>
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading text-center">
                    <h2 class="h5">瀏覽器使用</h2>
                </header>
                @foreach($browserUsage as $browserItem)
                    <div class="clearfix px-4 {{ !$loop->first ? 'py-1' : '' }} {{ $loop->last ? 'pb-2' : '' }}">
                        <span class="flot-left small">{{ $browserItem['browser'] }}</span>
                        <span class="float-right"><span class="badge badge-pill badge-danger">{{ $browserItem['sessions'] * 100 / $browserUsage->sum('sessions') }}%</span></span>
                    </div>
                    @if(!$loop->last)
                    <hr class="my-2 w-100">
                    @endif
                @endforeach
            </section>
        </div>
        <div class="col-xl-6 col-lg-12">
            <section class="panel p-2">
                <div id="mapdiv" style="width: 100%; height: 420px;"></div>
            </section>
        </div>
    </div>
    <!-- / row-->
    <!-- row    -->
    <div class="row text-center mt-3">
        <!-- col-->
        <div class="col-xl-3 col-md-6 col-sm-6">
            <section class="panel p-3 bg-danger text-white">
                <div class="row">
                    <div class="col"><span class="d-block mb-1 h3">{{ $todayVisitor }}</span><span class="d-block">今日參觀量</span></div>
                    <div class="col"><span class="icon-accessibility display-4"></span></div>
                </div>
            </section>
        </div>
        <!-- / col-->
        <!-- col-->
        <div class="col-xl-3 col-md-6 col-sm-6">
            <section class="panel p-3 bg-warning text-white">
                <div class="row">
                    <div class="col"><span class="d-block mb-1 h3">{{ $contactAmount }}</span><span class="d-block">客服信函</span></div>
                    <div class="col"><span class="icon-mail-envelope-open display-4"></span></div>
                </div>
            </section>
        </div>
        <!-- / col-->
        <!-- col-->
        {{--<div class="col-xl-3 col-md-6 col-sm-6">--}}
            {{--<section class="panel p-3 bg-success text-white">--}}
                {{--<div class="row">--}}
                    {{--<div class="col"><span class="d-block mb-1 h3">433</span><span class="d-block">產品數量</span></div>--}}
                    {{--<div class="col"><span class="icon-database display-4"></span></div>--}}
                {{--</div>--}}
            {{--</section>--}}
        {{--</div>--}}
        <!-- / col-->
        <!-- col-->
        {{--<div class="col-xl-3 col-md-6 col-sm-6">--}}
            {{--<section class="panel p-3 bg-primary text-white">--}}
                {{--<div class="row">--}}
                    {{--<div class="col"><span class="d-block mb-1 h3">3156</span><span class="d-block">粉絲團</span></div>--}}
                    {{--<div class="col"><span class="icon-facebook display-4"></span></div>--}}
                {{--</div>--}}
            {{--</section>--}}
        {{--</div>--}}
        <!-- / col-->
    </div>
    <!-- / row-->
    <!-- row  -->
    <div class="row mt-3">
        <div class="col-xl-6 col-lg-12">
            <section class="panel">
                <header class="panel-heading mb-2">
                    <h2 class="h5 float-left">近期聯絡表單</h2>
                    <div class="float-right"><a class="btn btn-danger btn-sm mr-15" href="{{ url('siteadmin/Contact/') }}">瀏覽全部</a></div>
                </header>
                <div class="panel-wrapper">
                    <div class="panel-body" style="min-height:270px;">
                        <div class="table-wrap">
                            <table class="table table-responsive">
                                <thead class="font-weight-bold">
                                <tr>
                                    <th class="hidden-lg-down">#</th>
                                    <th class="hidden-lg-down">日期</th>
                                    <th class="text-nowrap">姓名</th>
                                    <th>主題</th>
                                    <th class="hidden-lg-down">狀態</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $chkLabel = [
                                    'Y' => ['label' => '已回覆', 'class' => 'badge-success'],
                                    'N' => ['label' => '待回覆', 'class' => 'badge-danger'],
                                    'D' => ['label' => '忽略', 'class' => 'badge-default'],
                                ];
                                ?>
                                @foreach($contactData as $key => $contactItem)
                                <tr>
                                    <th class="text-center hidden-lg-down" scope="row">{{ $key + 1 }}</th>
                                    <td class="text-nowrap hidden-lg-down">{{ $contactItem->created_at->format('Y-m-d') }}</td>
                                    <td class="text-muted" style="min-width: 6em;">{{ $contactItem->name }}</td>
                                    <td style="min-width: 30em;">
                                        <a class="text-danger text-nowrap"
                                           href="{{ url('siteadmin/Contact/' . $contactItem->guid . '/edit') }}"
                                           title="{{ $contactItem->subject }}">
                                            {{ $contactItem->subject }}
                                        </a>
                                    </td>
                                    <td class="hidden-lg-down">
                                        <span class="badge badge-pill {{ $chkLabel[$contactItem->chk]['class'] }}">{{ $chkLabel[$contactItem->chk]['label'] }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                @if($contactData->count() < 1)
                                <tr>
                                    <td class="text-center" colspan="5">沒有聯絡表單</td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="h5 float-left">瀏覽年齡層</h2>
                </header>
                <div class="panel-wrapper"></div>
                <div class="panel-body pb-3">
                    <div id="analyticsAge" style="height:265px;"></div>
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="h5 float-left">熱門關鍵字</h2>
                </header>
                <div class="panel-wrapper"></div>
                <div class="panel-body" style="min-height:270px;">
                    <div class="table-wrap">
                        <table class="table table-responsive">
                            <thead class="font-weight-bold">
                            <tr>
                                <th>#</th>
                                <th>關鍵字</th>
                                <th>次數</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($referrerKeyword as $key => $keywordItem)
                            <tr>
                                <th class="text-center" scope="row">{{ $key + 1 }}</th>
                                <td>{{ $keywordItem['keyword'] }}</td>
                                <td>{{ $keywordItem['count'] }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- / row-->
    <!-- / layout-content-->
</div>
@endsection

@push('scripts')
<!-- ammap -->
<script src="{{ asset('admin/js/components/amcharts/ammap.js') }}"></script>
<script src="{{ asset('admin/js/components/amcharts/maps/js/worldLow.js') }}"></script>
<!-- amcharts -->
<script src="{{ asset('admin/js/components/amcharts/amcharts.js') }}"></script>
<script src="{{ asset('admin/js/components/amcharts/pie.js') }}"></script>
<script src="{{ asset('admin/js/components/amcharts/serial.js') }}"></script>
<script src="{{ asset('admin/js/components/amcharts/plugins/export/export.min.js') }}"></script>
<script src="{{ asset('admin/js/components/amcharts/plugins/dataloader/dataloader.min.js') }}"></script>
<script src="{{ asset('admin/js/components/amcharts/themes/light.js') }}"></script>
<!-- page index -->
<script src="{{ asset('admin/js/index.js') }}"></script>
@endpush