{{-- * * lib --}}
<script src="{{ asset('admin/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('admin/js/lib/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin/js/lib/env.js') }}"></script>
<script src="{{ asset('admin/js/lib/popper.min.js') }}"></script>
{{-- * * * slimscroll 捲軸--}}
<script src="{{ asset('components/slimscroll/jquery.slimscroll.js') }}"></script>
{{-- * * * bootstrap4--}}
<script src="{{ asset('components/bootstrap4/bootstrap.min.js') }}"></script>
{{-- * * * imgLiquid 圖片縮圖--}}
<script src="{{ asset('components/imgLiquid-master/imgLiquid-min.js') }}"></script>
{{-- * * * fancybox 媒體彈跳視窗 --}}
<script src="{{ asset('components/fancybox/jquery.fancybox.min.js') }}"></script>
{{-- * * * bootstrap-sweetalert 彈跳訊息視窗--}}
<script src="{{ asset('components/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('components/sweetalert/ui-sweetalert.min.js') }}"></script>
{{-- * * * bootstrap-tabdrop 切換tab下拉選單--}}
<script src="{{ asset('components/tabdrop/js/bootstrap-tabdrop.js') }}"></script>
<script src="{{ asset('admin/js/init.js') }}"></script>
{{-- * * * DataTables 表格--}}
<script src="{{ asset('components/datatables/datatables.min.js') }}"></script>
{{-- * * * CKEditor 編輯器--}}
<script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
{{-- * * * Bootstrap Daterangepicker 日期區間--}}
<script src="{{ asset('components/bootstrap-daterangepicker-master/moment.min.js') }}"></script>
<script src="{{ asset('components/bootstrap-daterangepicker-master/daterangepicker.js') }}"></script>
{{-- * * * bootstrap-select 下拉選單--}}
<script src="{{ asset('components/bootstrap-select/bootstrap-select.js') }}"></script>
{{-- * * * multiselect 分類左右選擇 select multiple--}}
<script src="{{ asset('components/multiselect/js/jquery.multi-select.js') }}"></script>
{{-- * * * multiselect 分類左右選擇 搜尋框 jquery-quicksearch--}}
<script src="{{ asset('components/quicksearch-master/jquery.quicksearch.js') }}"></script>
<script src="{{ asset('components/select2/js/select2.full.min.js') }}"></script>
{{-- * * * typeahead 建議字詞清單 typeahead.bundle.js--}}
<script src="{{ asset('components/typeahead/typeahead.bundle.js') }}"></script>
{{-- * * * validate 表單驗證--}}
<script src="{{ asset('components/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('components/validate/additional-methods.js') }}"></script>
{{-- * * * inputmask 表單格式--}}
<script src="{{ asset('components/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
{{-- * * * elFinder 檔案管理--}}
<script src="{{ asset('components/elFinder/js/elfinder.full.js') }}"></script>
@switch(app()->getLocale())
    @case('tw')
    <script src="{{ asset('components/elFinder/js/i18n/elfinder.zh_TW.js') }}"></script>
    @break
    @case('cn')
    <script src="{{ asset('components/elFinder/js/i18n/elfinder.zh_CN.js') }}"></script>
    @break
    @case('jp')
    <script src="{{ asset('components/elFinder/js/i18n/elfinder.ja.js') }}"></script>
    @break
@endswitch
{{-- * * * jquery.repeater.min.js 新增欄位--}}
<script src="{{ asset('components/repeater/jquery.repeater.min.js') }}"></script>
{{-- * * * bootstrap-colorpicker-master 顏色選取--}}
<script src="{{ asset('components/bootstrap-colorpicker-master/js/bootstrap-colorpicker.min.js') }}"></script>
{{-- * * * nestable 排序拖曳--}}
<script src="{{ asset('components/nestable/jquery.nestable.js') }}"></script>
{{-- * * * dropzonejs 檔案上傳--}}
<script src="{{ asset('components/dropzonejs/dropzone.js') }}"></script>
{{-- * * * Jcrop Image Cropping Plugin 圖片座標截圖 --}}
<script src="{{ asset('components/jcrop/jquery.Jcrop.min.js') }}"></script>
<script src="{{ asset('components/jcrop/jquery.color.js') }}"></script>

{{-- Custom --}}
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('admin/js/validate.js') }}"></script>
<script src="{{ asset('admin/js/datatables.js') }}"></script>
<script src="{{ asset('admin/js/typeahead.js') }}"></script>
<script src="{{ asset('admin/js/ajax.js') }}"></script>

@stack('scripts')