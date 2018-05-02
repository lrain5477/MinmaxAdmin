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

