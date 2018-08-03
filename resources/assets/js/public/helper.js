window.$ = window.jquery = require('jquery');

// ----- functions -----
function browserDetect() {
    var phone = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    var Android = /Android/i.test(navigator.userAgent);
    var iOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
    var IE = /MSIE|Trident/i.test(window.navigator.userAgent);

    var chrome = navigator.userAgent.indexOf('Chrome') > -1;
    var explorer = navigator.userAgent.indexOf('MSIE') > -1;
    var firefox = navigator.userAgent.indexOf('Firefox') > -1;
    var safari = navigator.userAgent.indexOf("Safari") > -1;
    var camino = navigator.userAgent.indexOf("Camino") > -1;
    var opera = navigator.userAgent.toLowerCase().indexOf("op") > -1;
    if ((chrome) && (safari)) safari = false;
    if ((chrome) && (opera)) chrome = false;

    if (!phone) {
        // not mobile
        $('html').addClass("not-mobile-mode");

        if (navigator.userAgent.indexOf('Mac OS X') != -1) {
            //is Mac
        } else {
            //is PC
        }
    } else {
        // mobile
        $('html').addClass("mobile-mode");
        if (!iOS) {
            // not iOS
        } else {
            // is iOS
            $('html').addClass("ios-mode");
            var ua = navigator.userAgent.toLowerCase();
            if (ua.indexOf('safari') != -1) {
                if (navigator.userAgent.match('CriOS')) {
                    // alert("iOS Chrome") // Chrome
                } else if (navigator.userAgent.match('FxiOS')) {
                    // alert("iOS Firefox") // Firefox
                } else {
                    // alert("iOS Safari") // Chrome
                    $('html').addClass("ios-safari-mode");
                }
            } else {
                // alert("iOS other") // Chrome
            }
        }
    }
    // alert(window.navigator.userAgent)

    /** detect IE version **/

    if (!IE) {
        $('html').removeClass("IE-mode");
    } else {
        //Do internet explorer exclusive behaviour here
        $('html').addClass("IE-mode");
    }

}
browserDetect();

export default { browserDetect }
