$(document).ready(function () {
    /*--------------------------------------------
          		validate  表格驗證
    ---------------------------------------------*/
    $.extend($.validator.messages, {
        required: "請輸入",
        remote: "請修正",
        email: "請輸入Email格式",
        url: "請輸入網址格式",
        date: "請輸入日期格式",
        dateISO: "請輸入有效日期(YYYY-MM-DD)",
        creditcard: "請輸入有效的信用卡號碼",
        number: "請輸入數字",
        digits: "請輸入數字",
        equalTo: "您輸入的不相同",
        maxlength: $.validator.format("不能超過 {0} 字元"),
        minlength: $.validator.format("最少需 {0} 字元."),
        rangelength: $.validator.format("請輸入長度在 {0} 到 {1} 之間字元."),
        range: $.validator.format("請在 {0} 到 {1} 之間輸入一個值"),
        max: $.validator.format("請輸入小於或等於 {0} 的數值"),
        min: $.validator.format("請輸入大於或等於 {0} 的數值"),
        step: $.validator.format("請輸入 {0} 的倍數")
    });
    jQuery.validator.setDefaults({
        debug: true,
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "div",
        focusCleanup: true,
        invalidHandler: function (e, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                var message = errors === 1 ? '您還有 1 個欄位有問題' : '您還有 ' + errors + ' 個欄位有問題';
                $("div.error span.text").html(message);
                $("div.error").addClass('show').show();
            } else {
                $("div.error").removeClass('show').hide();
            }
        },
        submitHandler: function(form) {
            $("input[type=submit]", form).prop('disabled' , true);
            form.submit();
        }
    });
    $('form.validate').each(function () {
        $("div.error").hide();
        $(this).validate();
    });
});