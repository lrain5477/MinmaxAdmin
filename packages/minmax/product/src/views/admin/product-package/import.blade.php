<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Io\Models\IoConstruct $formData
 */
?>

<form id="importForm" class="form-horizontal validate importForm"  name="importForm"
      action="{{ langRoute("admin.{$pageData->uri}.import", ['id' => $formData->id]) }}"
      method="post"
      enctype="multipart/form-data">
    @csrf

    <fieldset class="mt-4">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="ProductPackage-file">@lang('MinmaxProduct::io.ProductPackage.import.file_label')<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <input class="custom-file-input" name="ProductPackage[file]" type="file" id="ProductPackage-file" required />
                    <label class="custom-file-label" id="ProductPackage-file-label" for="ProductPackage-file">@lang('MinmaxBase::admin.form.file.default_text')</label>
                </div>
            </div>
            <small class="form-text text-muted ml-sm-auto col-sm-10">@lang('MinmaxProduct::io.ProductPackage.import.hint.file', ['link' => langRoute('admin.io-data.example', ['id' => $formData->id])])</small>
        </div>

    </fieldset>

    <fieldset class="mt-4">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-3"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductPackage.import.override_label')<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductPackage-override-0" name="ProductPackage[override]" value="0" checked />
                    <label class="custom-control-label" for="ProductPackage-override-0">@lang('MinmaxProduct::io.ProductPackage.import.options.override.0')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductPackage-override-1" name="ProductPackage[override]" value="1" />
                    <label class="custom-control-label" for="ProductPackage-override-1">@lang('MinmaxProduct::io.ProductPackage.import.options.override.1')</label>
                </div>
            </div>
            <small class="form-text text-muted ml-sm-auto col-sm-10">@lang('MinmaxProduct::io.ProductPackage.import.hint.override')</small>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductPackage.import.download_label')<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductPackage-download-0" name="ProductPackage[download]" value="0" checked />
                    <label class="custom-control-label" for="ProductPackage-download-0">@lang('MinmaxProduct::io.ProductPackage.import.options.download.0')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductPackage-download-1" name="ProductPackage[download]" value="1" />
                    <label class="custom-control-label" for="ProductPackage-download-1">@lang('MinmaxProduct::io.ProductPackage.import.options.download.1')</label>
                </div>
            </div>
        </div>

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
</form>

@push('scripts')
<script>
(function($) {
    $(function() {
        $('#ProductPackage-file').on('change', function() {
            if (this.files.length > 0) {
                $('#ProductPackage-file-label').text(this.files[0].name);
            } else {
                $('#ProductPackage-file-label').text('@lang('MinmaxBase::admin.form.file.default_text')');
            }
        });
    });
})(jQuery);
</script>
@endpush