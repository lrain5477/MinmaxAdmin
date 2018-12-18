<?php
/**
 * @var \Minmax\Base\Models\WebData $webData
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ $webData->website_name }} | @lang('MinmaxBase::admin.header.login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta charset="UTF-8" />
    <link href="{{ asset('static/admin/css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body class="login">
<div class="wrapper user-login2">
    <div class="login-container container">
        <div class="row">
            <div class="col-md-auto col text-center">
                <div class="login-content text-center text-sm-left">
                    <h1 class="text-main h3">
                        <span class="login-logo d-block d-sm-inline"><img class="mr-2 mb-3" src="{{ asset('static/admin/images/common/logo.png') }}" alt="" /></span><!--
                        --><span class="ml-2 d-block d-sm-inline">{{ $webData->website_name }}</span>
                    </h1>
                    <form id="loginForm" class="login-form mt-4" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-auto col-form-label" for="login-username">@lang('MinmaxBase::admin.login.username')</label>
                            <div class="col">
                                <input class="form-control" id="login-username" type="text" autocomplete="off" name="username" required />
                            </div>
                            <div class="col-auto"><i class="icon-profile-male h2 text-muted"></i></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-auto col-form-label" for="login-password">@lang('MinmaxBase::admin.login.password')</label>
                            <div class="col">
                                <input class="form-control" id="login-password" type="password" autocomplete="off" name="password" required />
                            </div>
                            <div class="col-auto d-none d-md-block"><i class="icon-key2 h2 text-muted"></i></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-auto col-form-label" for="login-captcha">@lang('MinmaxBase::admin.login.captcha')</label>
                            <div class="col">
                                <input class="form-control" type="text" id="login-captcha" autocomplete="off" name="captcha" required />
                            </div>
                            <div class="col-auto d-none d-md-block">
                                <img src="{{ langRoute('admin.captcha', ['name' => 'login']) }}" id="captcha-img" style="width:100px;height:auto;cursor:pointer;" alt="" />
                            </div>
                        </div>
                        <div class="row align-items-center mt-4">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="remember" name="remember" value="1"/>
                                    <label class="custom-control-label" for="remember">@lang('MinmaxBase::admin.login.remember')</label>
                                </div>
                            </div>
                            {{--<div class="col text-sm-left text-right">
                                <div class="forgot-password"><a class="forget-password text-secondary" id="forget-password" href="javascript:;">@lang('MinmaxBase::admin.login.forget')</a></div>
                            </div>--}}
                            <div class="col-sm text-md-right col-xs-12 text-center mt-4 mt-md-2">
                                <button class="btn btn-main btn-lg rounded" type="submit">@lang('MinmaxBase::admin.login.login_submit')</button>
                            </div>
                        </div>
                        <div class="alert alert-danger error fade mt-3" role="alert"><span class="text"></span></div>
                    </form>
                    {{--<form class="forget-form validator" action="javascript:;" method="post" data-toggle="validator">
                        <h3 class="text-main my-4">@lang('MinmaxBase::admin.login.forget')</h3>
                        <p class="mb-4">@lang('MinmaxBase::admin.login.info.forget')</p>
                        <div class="form-group row">
                            <div class="col-auto col-form-label">@lang('MinmaxBase::admin.login.email')</div>
                            <div class="col">
                                <input class="form-control" type="text" autocomplete="off" name="email">
                            </div>
                        </div>
                        <div class="text-left">
                            <button class="btn btn-outline-secondary btn-outline rounded" id="back-btn" type="button">返回</button>
                            <button class="btn btn-main rounded" type="submit">送出</button>
                        </div>
                    </form>--}}
                </div>
            </div>
            <div class="col d-md-block d-none">
                <div class="welcome-panl">
                    <h2 class="mb-3">@lang('MinmaxBase::admin.login.info.topic')</h2>
                    <p>@lang('MinmaxBase::admin.login.info.message', ['site' => $webData->website_name])</p>
                </div>
            </div>
        </div>
    </div>
    <div class="login-footer">
        <div class="login-copyright mb-3">
            <p>Copyright © {{ config('app.author') }} {{ date('Y') }}</p>
        </div>
    </div>
    <div class="login-bg">
        <div class="swiper-container" id="login-swiper">
            <div class="swiper-wrapper">
                <a class="swiper-slide imgFill"><img src="{{ asset('static/admin/images/demo/example/01.jpg') }}" alt="" /></a>
                <a class="swiper-slide imgFill"><img src="{{ asset('static/admin/images/demo/example/02.jpg') }}" alt="" /></a>
                <a class="swiper-slide imgFill"><img src="{{ asset('static/admin/images/demo/example/03.jpg') }}" alt="" /></a>
            </div>
        </div>
    </div>
</div>
{{-- * * lib --}}
<script src="{{ asset('static/modules/lib/jquery.min.js') }}"></script>
<script src="{{ asset('static/modules/lib/jquery-ui.js') }}"></script>
<script src="{{ asset('static/modules/lib/env.js') }}"></script>
<script src="{{ asset('static/modules/lib/popper.min.js') }}"></script>
{{-- * * common --}}
{{-- * * * bootstrap4 --}}
<script src="{{ asset('static/modules/bootstrap4/bootstrap.min.js') }}"></script>
{{-- * * * imgLiquid 圖片縮圖 --}}
<script src="{{ asset('static/modules/imgLiquid-master/imgLiquid-min.js') }}"></script>
{{-- * * * validate 表單驗證 --}}
<script src="{{ asset('static/modules/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('static/modules/validate/additional-methods.js') }}"></script>
<script src="{{ asset('static/admin/js/validate.js') }}"></script>
{{-- * * * swiper 圖片輪播 --}}
<script src="{{ asset('static/modules/swiper/js/swiper.min.js') }}"></script>
<script src="{{ asset('static/admin/js/login.js') }}"></script>
</body>
</html>