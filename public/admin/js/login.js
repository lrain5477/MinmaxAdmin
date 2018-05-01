var Login = function () {
    $(".forget-form").hide();
    $("#forget-password").click(function () {
        $(".login-form").hide(), $(".forget-form").show()
    }), $("#back-btn").click(function () {
        $(".login-form").show(), $(".forget-form").hide()
    });
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: {delay: 3000},
        effect: 'cube',
        speed: 1000
    });
};

jQuery(document).ready(function () {
    $('#getCaptcha').click(function(){
        $('#rand-img').attr('src', '/administrator/login/captcha' + (new Date()).getMilliseconds());
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

