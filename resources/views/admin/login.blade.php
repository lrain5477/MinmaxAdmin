<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>MINMAX 總後台管理系統 | 登入</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/js/sweetalert/sweetalert.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body class="login">
<div class="wrapper user-login">
    <div class="login-logo"><img class="mr-2" src="{{ asset('admin/images/logo.png') }}"><span>MINMAX</span></div>
    <div class="row no-gutters">
        <div class="col-lg-6 login-container">
            <div class="login-content">
                <h1>@lang('admin.login.title')</h1>
                <p>@lang('admin.login.info.login')</p>

                <form class="login-form" action="" method="post" data-toggle="validator" id="loginForm"  name="loginForm">
                    @if($errors->count())
                    <div class="alert alert-danger error fade show" role="alert"><span class="text">{{ $errors->first() }}</span></div>
                    @else
                    <div class="alert alert-danger error fade" role="alert"><span class="text"></span></div>
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-sm">
                            <input class="form-control form-group" type="text" autocomplete="off" placeholder="Username" id="login-username" name="username" value="{{ old('username') }}" style="{{ $errors->has('username') ? 'border: 1px dotted #ff0000' : '' }}" required>
                        </div>

                        <div class="col-sm">
                            <input class="form-control form-group" type="password" autocomplete="off" placeholder="Password" id="login-password" name="password" required>
                        </div>

                        <div class="col-sm captcha">
                            <input class="form-control form-group" type="text" autocomplete="off" placeholder="@lang('admin.login.captcha')" name="captcha" id="captcha" maxlength="4">
                            <img src="{{ route('admin.loginCaptcha') }}" style="width:100px;height:auto;" id="rand-img" name="rand-img">
                            <button class="btn btn-" type="button" id="getCaptcha" name="getCaptcha"><i class="icon-rotate"></i></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <button class="btn btn-danger" type="submit" id="subBtn">@lang('admin.login.login_submit')</button>
                        </div>

                        <div class="col-auto">
                            <div class="rem-password">

                                <div class="custom-control custom-checkbox rememberme">
                                    <input class="custom-control-input" type="checkbox" id="remember" name="remember" value="1"/>
                                    <label class="custom-control-label" for="remember">@lang('admin.login.remember')</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="forgot-password"><a class="forget-password" id="forget-password" href="javascript:;">@lang('admin.login.forget')</a></div>
                        </div>
                    </div>
                </form>

                <form class="forget-form validator" action="javascript:;" method="post" data-toggle="validator">
                    @csrf
                    <h3 class="text-danger">@lang('admin.login.forget')</h3>
                    <p>@lang('admin.login.info.forget')</p>

                    <div class="form-group">
                        <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" name="email">
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-outline-secondary btn-outline" id="back-btn" type="button">@lang('admin.login.back_button')</button>
                        <button class="btn btn-danger uppercase pull-right" type="submit">@lang('admin.login.forget_submit')</button>
                    </div>
                </form>
            </div>

            <div class="login-footer">
                <div class="login-copyright mb-3">
                    <p>Copyright © MINMAX {{ date('Y') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 login-bg">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide imgFill"><img src="{{ asset('admin/images/example/iStock-515518781.jpg') }}"></div>
                    <div class="swiper-slide imgFill"><img src="{{ asset('admin/images/example/iStock-628319502.jpg') }}"></div>
                    <div class="swiper-slide imgFill"><img src="{{ asset('admin/images/example/iStock-628609112.jpg') }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- * lib-->
<script src="{{ asset('admin/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('admin/js/lib/env.js') }}"></script>
<script src="{{ asset('admin/js/lib/popper.min.js') }}"></script>
<!-- * * bootstrap4-->
<script src="{{ asset('components/bootstrap4/bootstrap.min.js') }}"></script>
<!-- * * imgLiquid 圖片縮圖-->
<script src="{{ asset('components/imgLiquid-master/imgLiquid-min.js') }}"></script>
<!-- * * swiper 圖片輪播-->
<script src="{{ asset('components/swiper/js/swiper.min.js') }}"></script>
<script src="{{ asset('components/swiper/js/swiper.esm.bundle.js') }}"></script>
<script src="{{ asset('components/sweetalert/sweetalert.min.js') }}"></script>
<!-- * * validate 表單驗證-->
<script src="{{ asset('components/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('components/validate/additional-methods.js') }}"></script>

<script src="{{ asset('admin/js/init.js') }}"></script>
<script src="{{ asset('admin/js/login.js') }}"></script>
<script>
jQuery(document).ready(function () {
    $('#getCaptcha').click(function(){
        $('#rand-img').attr('src', '{{ route('admin.loginCaptcha') }}' + '/' + (new Date()).getMilliseconds());
    });

    $("#loginForm").validate({
        rules: {
            login_admin_id: { required: true, minlength: 4, maxlength: 16},
            login_passwd: {required: true, minlength: 4, maxlength: 16},
            captcha: {required: true}
        },
        success: function (error) {},
        invalidHandler: function (ev, validator) {
            var errors = validator.numberOfInvalids();

            if(errors) {
                $("div.error span").html('您還有 '+errors+' 個欄位有問題');
                $('.alert-danger').addClass('show');
            } else {
                $('.alert-danger').removeClass('show');
            }
        },
        errorPlacement: function(error, element) {},
        highlight: function(element){ $(element).css({'border': '1px dotted #ff0000'}); },
        unhighlight: function(element){ $(element).css({"border": ''}); },
        submitHandler: function(form) { $("#loginForm").submit(); }
    });

    Login();
});
</script>
</body>
</html>