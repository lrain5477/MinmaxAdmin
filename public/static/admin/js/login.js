$(function () {
    $("#login-swiper").each(function() {
        var mySwiper = new Swiper('#login-swiper', {
            autoplay: {delay: 3000},
            effect: 'fade',
            speed:1000
        });
    });

    $('#captcha-img').on('click', function () {
        var $this = $(this);
        var captchaUrl = $this.attr('src').replace(/\/[0-9]*$/, '') + '/';
        $this.attr('src', captchaUrl + (new Date()).getMilliseconds());
    });

    $("#loginForm").validate({
        rules: {
            username: { required: true, minlength: 4, maxlength: 16},
            password: {required: true, minlength: 4, maxlength: 16},
            captcha: {required: true}
        },
        success: function (error) {},
        invalidHandler: function (ev, validator) {
            var errors = validator.numberOfInvalids();

            if(errors) {
                $("div.error .text").html('您還有 '+errors+' 個欄位有問題');
                $('.alert-danger').addClass('show');
            } else {
                $('.alert-danger').removeClass('show');
            }
        },
        errorPlacement: function(error, element) {},
        highlight: function(element){ $(element).css({'border': '1px dotted #ff0000'}); },
        unhighlight: function(element){ $(element).css({"border": ''}); },
        submitHandler: function(form) { $('#subBtn').prop('disabled', true).text('登入中'); form.submit(); }
    });
});

