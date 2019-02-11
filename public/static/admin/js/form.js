$(document).ready(function () {

    /*--------------------------------------------
           		Form Bootstrap-Select.js  下拉搜尋
     ---------------------------------------------*/
    $('.bs-select').each(function () {
        $(this).selectpicker();
    });

    /*--------------------------------------------
           		Form select2.js  下拉搜尋
     ---------------------------------------------*/
    /**基本下拉 */
    $('.seclet2').each(function () {
        $(this).select2();
    });
    /**無搜尋匡 */
    $('.seclet2-hide-search').each(function () {
        $(this).select2({
            minimumResultsForSearch: 1 / 0
        });
    });
    /**可清除選取 */
    $('.seclet2-placeholder').each(function () {
        $(this).select2({
            placeholder: "Select a state",
            allowClear: !0
        });
    });
    /**限定數量選取 */
    $('.seclet2-length').each(function () {
        var $num = $(this).attr("size");
        var $text = $(this).attr("title");
        $(this).select2({
            maximumSelectionLength: $num,
            placeholder: $text + $num
        });
    });
    $('.select2-size-lg').each(function () {
        $(this).select2({
            containerCssClass: "select-lg"
        });
    });
    $('.select2-size-sm').each(function () {
        $(this).select2({
            containerCssClass: "select-sm"
        });
    });

    /*--------------------------------------------
              		Form multiselect.js  左右複選
    ---------------------------------------------*/
    $('.multiSelect').each(function () {

        $(this).multiSelect({
            selectableOptgroup: true,
            selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (ms) {
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function (e) {
                        if (e.which === 40) {
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function (e) {
                        if (e.which == 40) {
                            that.$selectionUl.focus();
                            return false;
                        }
                    });

            },
            afterSelect: function () {
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function () {
                this.qs1.cache();
                this.qs2.cache();
            }
        });
    });
    $('.select-all').click(function () {
        $thisSelect = $(this).parent().prev().prev();
        $thisSelect.multiSelect('select_all');
        return false;
    });
    $('.deselect-all').click(function () {
        $thisSelect = $(this).parent().prev().prev();
        $thisSelect.multiSelect('deselect_all');
        return false;
    });
    /*--------------------------------------------
         Form inputmask.bundle.min.js  欄位格式
    ---------------------------------------------*/
    $(":input[data-inputmask]").each(function () {
        $(this).inputmask();
    });
    /*--------------------------------------------
             Form repeater 欄位增加
        ---------------------------------------------*/
    $(".repeater").each(function () {
        $(this).repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (remove) {
                if (confirm('Remove?')) {
                    $(this).slideUp(remove);
                }
            }
        });
    });

    /*--------------------------------------------
                 Form daterangepicker 日期區間
    ---------------------------------------------*/
    /**單一日期 */
    $('.datepicker-birthdate').each(function () {
        $(this).daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD',
                "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                "monthNames": ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            },
        });
        $(this).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
        $(this).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
    /**單一日期+時間 */
    $('.datepicker-birthdateTime').each(function () {
        $(this).daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD HH:mm:00',
                "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                "monthNames": ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            }
        });
        $(this).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:00'));
        });
        $(this).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
    /**常用區間下拉 */
    $('.datepicker-reportrange').each(function () {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $(this).html(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'));
        }

        $(this).daterangepicker({
            startDate: start,
            endDate: end,
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD',
                "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                "monthNames": ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            },
            ranges: {
                '今天': [moment(), moment()],
                '昨天': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '最近7天': [moment().subtract(6, 'days'), moment()],
                '最近30天': [moment().subtract(29, 'days'), moment()],
                '本月': [moment().startOf('month'), moment().endOf('month')],
                '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
        $(this).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $(this).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
    /**日期區間 */
    $('.datepicker-datefilter').each(function () {
        $(this).daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD',
                "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                "monthNames": ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            }
        });

        $(this).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $(this).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    /**日期區間+時間 */
    $('.datepicker-timepicker').each(function () {
        $(this).daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD HH:mm:00'
            }
        });
        $(this).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:00') + ' ~ ' + picker.endDate.format('YYYY-MM-DD HH:mm:00'));
        });
        $(this).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
    /**限制區間固定天數 */
    $('.datepicker-limit').each(function () {
        var $minDate = $(this).attr("minDate");
        var $maxDate = $(this).attr("maxDate");
        var $dateLimit = $(this).attr("dateLimit");
        $(this).daterangepicker({
            format: 'YYYY-MM-DD',
            minDate: $minDate,
            autoUpdateInput: false,
            maxDate: $maxDate,
            dateLimit: {
                days: $dateLimit
            },
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD HH:mm:00',
                "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                "monthNames": ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            }
        });
        $(this).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:00') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:00'));
        });
        $(this).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
    /*--------------------------------------------
           bootstrap-colorpicker 顏色點選
    ---------------------------------------------*/
    /**顏色切換 */
    $('.colorpicker-component').each(function () {
        $(this).colorpicker({
            format: 'rgba',
            colorSelectors: {
                'white': '#ffffff',
                'black': '#000000',
                'default': '#777777',
                'lightgray': '#ccc',
                'red': '#FF0000',
                'danger': '#d9534f',
                'warning': '#f0ad4e',
                'yellow': '#f7db1c',
                'primary': '#337ab7',
                'info': '#5bc0de',
                'success': '#5cb85c',
            }
        });
    });

    /**更改背景顏色 */
    $('.colorpicker-changebg').each(function () {
        var $dateName = $(this).attr("dateName");
        $(this).colorpicker({
            format: 'rgba',
            colorSelectors: {
                'white': '#ffffff',
                'black': '#000000',
                'default': '#777777',
                'lightgray': '#ccc',
                'red': '#FF0000',
                'danger': '#d9534f',
                'warning': '#f0ad4e',
                'yellow': '#f7db1c',
                'primary': '#337ab7',
                'info': '#5bc0de',
                'success': '#5cb85c',
            }
        });
        $(this).colorpicker().on('changeColor', function (e) {
            $($dateName)[0].style.backgroundColor = e.color.toString(
                'rgba');
        });
    });
    /**更改文字顏色 */
    $('.colorpicker-changefont').each(function () {
        var $dateName = $(this).attr("dateName");
        $(this).colorpicker({
            format: 'rgba',
            colorSelectors: {
                'white': '#ffffff',
                'black': '#000000',
                'default': '#777777',
                'lightgray': '#ccc',
                'red': '#FF0000',
                'danger': '#d9534f',
                'warning': '#f0ad4e',
                'yellow': '#f7db1c',
                'primary': '#337ab7',
                'info': '#5bc0de',
                'success': '#5cb85c',
            }
        });
        $(this).colorpicker().on('changeColor', function (e) {
            $($dateName)[0].style.color = e.color.toString('rgba');
        });
    });
    /*--------------------------------------------
           nestable 拖曳排序
    ---------------------------------------------*/
    $('.nestable').each(function () {
        $(this).nestable();
    });

});

var substringMatcher = function(strings) {
    return function findMatches(q, cb) {
        var matches = [], substringRegex = new RegExp(q, 'i');
        $.each(strings, function(i, str) {
            if (substringRegex.test(str)) matches.push(str);
        });
        cb(matches);
    };
};