"use strict";
var $wrapper = $(".wrapper");
var $pageHeader = $(".page-header");
var $pageContent = $(".page-content");
var $contentBody = $(".content-body");
var $contentHeader = $(".content-header");
var $contentH = $(".contentH");
var $pageFooter = $(".page-footer");
var $panel = $(".panel");
var width = $(window).width();
var $mobileW = 1199;

/*--------------------------------------------
 卷軸
 ---------------------------------------------*/
$('.nicescroll-bar').each(function() {
    $(this).slimscroll({
        height: '100%',
        color: '#878787',
        disableFadeOut: true,
        borderRadius: 0,
        size: '4px',
        alwaysVisible: false
    });
});

/** 行動版本預設選單關閉 **/
if (width < $mobileW) {
    $wrapper.addClass('slide-nav-close');
}

var minmax = function() {

    /*--------------------------------------------
     Textarea 自動增高
     ---------------------------------------------*/
    $("textarea.autoHeight").each(function() {
        $(this).css("overflow", "hidden").bind("keydown keyup", function() {
            $(this).height('0px').height($(this).prop("scrollHeight") + 'px');
        }).keydown();
    });

    /*--------------------------------------------
     內容最小高度
     ---------------------------------------------*/
    var contentBodyH = function() {
        var h = $(window).outerHeight();
        var contentH = $contentHeader.outerHeight();
        var pageF = $pageFooter.outerHeight();
        var pageH = $pageHeader.height();
        var contentHeight = h - contentH - pageH - 30;
        var panelLength = $panel.length;

        if (panelLength === 1) {
            if (width < 576) {
                $panel.css({minHeight: contentHeight + pageH});
            } else {
                $panel.css({minHeight: contentHeight});
            }
        }
    };
    contentBodyH();

    /*--------------------------------------------
     左側主選單開閉
     ---------------------------------------------*/
    $(document).on('click', '#toggle_nav_btn', function() {
        $wrapper.toggleClass('slide-nav-close');
        return false;
    });

    /*--------------------------------------------
     選單螢幕自動關閉開啟
     ---------------------------------------------*/
    var navCloseAuto = function() {
        var width = $(window).width();
        if (width < $mobileW) {
            if ($(".slide-nav-close").length < 1) {
                setTimeout(function() {
                    $wrapper.addClass('slide-nav-close');
                }, 200)
            }
        } else {
            if ($(".slide-nav-close").length > 0) {
                setTimeout(function() {
                    $wrapper.removeClass('slide-nav-close');
                }, 200)
            }
        }
    };

    $(window).resize(function() {
        contentBodyH();
        navCloseAuto();
    });

    /*--------------------------------------------
     側選單自動打開
     ---------------------------------------------*/
    $(document).on('click', '.fixed-sidebar-left a[data-toggle="collapse"]', function() {
        if ($(".slide-nav-close").length > 0) {
            $wrapper.removeClass('slide-nav-close');
        }
    });

    /*--------------------------------------------
     imgLiquid.js  圖片縮圖
     ---------------------------------------------*/
    $(".imgFill").each(function() {
        $(this).imgLiquid();
    });

    /*--------------------------------------------
     拖曳排序
     ---------------------------------------------*/
     $(".file-img-list").each(function() {
        $(this).sortable();
        $(this).disableSelection();
    });

    /*--------------------------------------------
     圖片輪播
     ---------------------------------------------*/
    $(".swiper-fade").each(function() {
        var swiper = new Swiper('.swiper-fade', {
            autoplay: {
                delay: 3000,
              },
              effect: 'fade',
              speed:1000
        });
    });

    /*--------------------------------------------
     代碼顏色
     ---------------------------------------------*/
    hljs.initHighlightingOnLoad();

    /*--------------------------------------------
     bootstrap-tooltips 提示
     ---------------------------------------------*/
    $('[data-toggle="tooltip"]').each(function () {
        $(this).tooltip();
    });

    /*--------------------------------------------
     bootstrap-popover 提示
     ---------------------------------------------*/
    $('[data-toggle="popover"]').each(function () {
        $(this).popover();
    });

    /*--------------------------------------------
     顯示code
     ---------------------------------------------*/
    $('.highlight').each(function () {
        $(this).hide();
    });
    $('.btn-code').each(function () {
        $(this).click(function() {
            $('.highlight').toggle();
        });
    });
};

/**
 * Get language text.
 * @param   {object} $languageObj
 * @param   {string} parameters
 * @returns {*}
 */
function getLanguage($languageObj, parameters) {
    var $currentLayer = $languageObj, paramArray = parameters.split('.');
    for (var layer = 0; layer < paramArray.length; layer++) {
        var currentParam = paramArray[layer];
        if (typeof $currentLayer === 'object' && $currentLayer.hasOwnProperty(currentParam)) {
            $currentLayer = $currentLayer[currentParam];
        }
    }

    if (typeof $currentLayer === 'object') {
        return parameters;
    } else {
        return $currentLayer;
    }
}

/***** Ready function start *****/
$(function() {
    minmax();
});
