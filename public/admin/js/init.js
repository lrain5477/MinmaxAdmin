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

/* 行動版本預設選單關閉 */
if (width < 1280) {
    $wrapper.addClass('slide-nav-close');
}

/*****Ready function start*****/
$(document).ready(function() {
    minmax();
});

var minmax = function() {

    /*下拉滑動特效*/
    /* var $dropdown = $('.dropdown');
    $dropdown.on('show.bs.dropdown', function(e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
    });
    $dropdown.on('hide.bs.dropdown', function(e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(150);
    });
    */


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
                $panel.css({
                    minHeight: contentHeight + pageH,
                });
            } else {
                $panel.css({
                    minHeight: contentHeight,
                });
            }
        }
    };
    contentBodyH();

    /*--------------------------------------------
       		左側主選單開閉
     ---------------------------------------------*/
    $(document).on('click', '#toggle_nav_btn', function(e) {
        $wrapper.toggleClass('slide-nav-close');
        return false;
    });

    /*--------------------------------------------
       		選單螢幕自動關閉開啟
     ---------------------------------------------*/
    var navCloseAuto = function() {
        if (width < 1280) {
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
};