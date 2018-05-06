@extends('admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::render('create'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('admin.form.create')</h1>

        @yield('action-buttons')
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="createForm" class="form-horizontal validate createForm"  name="createForm"
                  action="{{ route('admin.store', [$pageData->uri]) }}"
                  method="post"
                  enctype="multipart/form-data">
                @csrf

                @yield('forms')
            </form>
        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection

@push('scripts')
<script>
(function($) {
    $(function() {
        $('.editor').each(function () {
            CKEDITOR.replace($(this).attr('id'), {customConfig: 'config.js', width: '100%', height: '250px', filebrowserBrowseUrl: '/siteadmin/elfinder/ckeditor'});
        });
        $('.editor-full').each(function () {
            CKEDITOR.replace($(this).attr('id'), {customConfig: 'config.js', width: '100%', height: '550px', filebrowserBrowseUrl: '/siteadmin/elfinder/ckeditor'});
        });
        if($('.editor').length > 0 || $('.editor-full').length > 0) {
            CKEDITOR.dtd.$removeEmpty['i'] = false;
        }
    });
})(jQuery);
</script>
@endpush