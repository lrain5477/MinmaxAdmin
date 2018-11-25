{{-- *   js --}}
{{-- * * lib --}}
<script src="{{ asset('static/modules/lib/jquery.min.js') }}"></script>
<script src="{{ asset('static/modules/lib/jquery-ui.js') }}"></script>
<script src="{{ asset('static/modules/lib/jquery.browser.js') }}"></script>
<script src="{{ asset('static/modules/lib/popper.min.js') }}"></script>
{{-- * * common --}}
{{-- * * * slimscroll 捲軸 --}}
<script src="{{ asset('static/modules/slimscroll/jquery.slimscroll.js') }}"></script>
{{-- * * * bootstrap4 --}}
<script src="{{ asset('static/modules/bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ asset('static/modules/bootstrap4/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('static/modules/bootstrap4/vendor/popper.min.js') }}"></script>
<script src="{{ asset('static/modules/bootstrap4/vendor/holder.min.js') }}"></script>
{{-- * * * imgLiquid 圖片縮圖 --}}
<script src="{{ asset('static/modules/imgLiquid-master/imgLiquid-min.js') }}"></script>
{{-- * * * fancybox 媒體彈跳視窗 --}}
<script src="{{ asset('static/modules/fancybox/jquery.fancybox.min.js') }}"></script>
{{-- * * * bootstrap-sweetalert 彈跳訊息視窗 --}}
<script src="{{ asset('static/modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('static/modules/sweetalert/ui-sweetalert.min.js') }}"></script>
{{-- * * * bootstrap-tabdrop 切換tab下拉選單 --}}
<script src="{{ asset('static/modules/tabdrop/js/bootstrap-tabdrop.js') }}"></script>
{{-- * * * swiper 圖片輪播 --}}
<script src="{{ asset('static/modules/swiper/js/swiper.min.js') }}"></script>
<script src="{{ asset('static/modules/swiper/js/swiper.esm.bundle.js') }}"></script>
{{-- * / js--}}

{{-- * layout-js --}}
{{-- * * list --}}
{{-- * * * DataTables 表格 --}}
<script src="{{ asset('static/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('static/modules/datatables/dataTables.responsive.min.js') }}"></script>
{{-- * * form --}}
{{-- * * * ckeditor 編輯器 --}}
<script src="{{ asset('static/modules/ckeditor/ckeditor.js') }}"></script>
{{-- * * * Bootstrap Daterangepicker 日期區間 --}}
<script src="{{ asset('static/modules/bootstrap-daterangepicker-master/moment.min.js') }}"></script>
<script src="{{ asset('static/modules/bootstrap-daterangepicker-master/daterangepicker.js') }}"></script>
{{-- * * * bootstrap-select 下拉選單 --}}
<script src="{{ asset('static/modules/bootstrap-select/bootstrap-select.js') }}"></script>
{{-- * * * multiselect 分類左右選擇 select multiple --}}
<script src="{{ asset('static/modules/multiselect/js/jquery.multi-select.js') }}"></script>
{{-- * * * multiselect 分類左右選擇 搜尋框 jquery-quicksearch --}}
<script src="{{ asset('static/modules/quicksearch-master/jquery.quicksearch.js') }}"></script>
<script src="{{ asset('static/modules/select2/js/select2.full.min.js') }}"></script>
{{-- * * * typeahead 建議字詞清單 typeahead.bundle.js --}}
<script src="{{ asset('static/modules/typeahead/typeahead.bundle.js') }}"></script>
{{-- * * * validate 表單驗證 --}}
<script src="{{ asset('static/modules/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('static/modules/validate/additional-methods.js') }}"></script>
{{-- * * * inputmask 表單格式 --}}
<script src="{{ asset('static/modules/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
{{-- * * * elFinder 檔案管理 --}}
<script src="{{ asset('static/modules/elFinder/js/elfinder.full.js') }}"></script>
@switch(app()->getLocale())
    @case('zh-Hant')
    <script src="{{ asset('static/modules/elFinder/js/i18n/elfinder.zh_TW.js') }}"></script>
    @break
    @case('zh-Hans')
    <script src="{{ asset('static/modules/elFinder/js/i18n/elfinder.zh_CN.js') }}"></script>
    @break
    @case('ja')
    <script src="{{ asset('static/modules/elFinder/js/i18n/elfinder.jp.js') }}"></script>
    @break
@endswitch
{{-- * * * jquery.repeater.min.js 新增欄位 --}}
<script src="{{ asset('static/modules/repeater/jquery.repeater.min.js') }}"></script>
{{-- * * * bootstrap-colorpicker-master 顏色選取 --}}
<script src="{{ asset('static/modules/bootstrap-colorpicker-master/js/bootstrap-colorpicker.min.js') }}"></script>
{{-- * * * nestable 排序拖曳 --}}
<script src="{{ asset('static/modules/nestable/jquery.nestable.js') }}"></script>
{{-- * * * dropzonejs 檔案上傳 --}}
<script src="{{ asset('static/modules/dropzonejs/dropzone.js') }}"></script>
{{-- * * * Jcrop Image Cropping Plugin 圖片座標截圖 --}}
<script src="{{ asset('static/modules/jcrop/jquery.Jcrop.min.js') }}"></script>
<script src="{{ asset('static/modules/jcrop/jquery.color.js') }}"></script>
{{-- * / layout-js--}}

<script src="{{ asset('static/modules/highlight/highlight.min.js') }}"></script>
<script src="{{ asset('static/admin/js/init.js') }}"></script>
<script src="{{ asset('static/admin/js/form.js') }}"> </script>
<script src="{{ asset('static/admin/js/validate.js') }}"></script>
<script src="{{ asset('static/admin/js/datatables.js') }}"></script>
<script src="{{ asset('static/admin/js/typeahead.js') }}"> </script>
<script src="{{ asset('static/admin/js/ajax.js') }}"></script>

@stack('scripts')
