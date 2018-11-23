"use strict";
//console.log(1);
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
       		page [main]代碼顏色
---------------------------------------------*/
hljs.initHighlightingOnLoad();
$(document).ready(function() {

    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
     });

    minmax();
});

var minmax = function() {
    /*--------------------------------------------
       		page [main]行 動版本預設選單關閉
    ---------------------------------------------*/
    if (width < 1620) {
        $wrapper.addClass('slide-nav-close');
    }
    /*--------------------------------------------
       		page [main] 內容最小高度
     ---------------------------------------------*/
    var contentBodyH = function() {
        var h = $(window).outerHeight();
        var contentH = $contentHeader.outerHeight();
        var pageF = $pageFooter.outerHeight();
        var pageH = $pageHeader.height();
        var contentHeight = h - contentH - pageH - 30;
        var panelLength = $panel.length;

        if (panelLength == 1) {
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
    }
    contentBodyH();
    /*--------------------------------------------
       		page [main]左側主選單開閉
     ---------------------------------------------*/
    $(document).on('click', '#toggle_nav_btn', function(e) {
        $wrapper.toggleClass('slide-nav-close');
        console.log(1);
        //return false;
    });
    /*--------------------------------------------
       		page [main]選單螢幕自動關閉開啟
     ---------------------------------------------*/
    // var navCloseAuto = function() {
    //     var width = $(window).width();
    //     if (width < 1620) {
    //         if ($(".slide-nav-close").length > 0) {
    //             return;
    //         } else {
    //             setTimeout(function() {
    //                 $wrapper.addClass('slide-nav-close');
    //             }, 200)
    //         }
    //     } else {
    //         if ($(".slide-nav-close").length > 0) {
    //             setTimeout(function() {
    //                 $wrapper.removeClass('slide-nav-close');
    //             }, 200)
    //         } else {
    //             return;
    //         }
    //     }
    //}
    /*--------------------------------------------
       		page [main]側選單自動打開
     ---------------------------------------------*/
    // $(document).on('click', '.fixed-sidebar-left a[data-toggle="collapse"]', function(e) {
    //     if ($(".slide-nav-close").length > 0) {
    //         $wrapper.removeClass('slide-nav-close');
    //     } else {
    //         return;
    //     }
    // });
    /*--------------------------------------------
       		拖曳排序
     ---------------------------------------------*/
     $(".file-img-list").each(function() {
        $(this).sortable();
        $(this).disableSelection();
    });
    
    $(window).resize(function() {
        contentBodyH();
        navCloseAuto();
    });
};