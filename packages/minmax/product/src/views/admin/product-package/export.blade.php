<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Io\Models\IoConstruct $formData
 */
?>

<form id="exportForm" class="form-horizontal exportForm"  name="exportForm"
      action="{{ langRoute("admin.{$pageData->uri}.export", ['id' => $formData->id]) }}"
      method="post"
      enctype="multipart/form-data">
    @csrf

    <fieldset class="mt-4">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-3"></i>@lang('MinmaxProduct::io.fieldSet.filter')</legend>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="ProductPackage-set_sku">@lang('MinmaxProduct::io.ProductPackage.export.set_sku_label')</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ProductPackage-set_sku" name="ProductPackage[set_sku]" value="" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="ProductPackage-item_sku">@lang('MinmaxProduct::io.ProductPackage.export.item_sku_label')</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ProductPackage-item_sku" name="ProductPackage[item_sku]" value="" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductPackage.export.created_at_label')</label>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductPackage-created_at-start"
                       name="ProductPackage[created_at][start]"
                       value=""
                       placeholder="Start Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductPackage-created_at-end"
                       name="ProductPackage[created_at][end]"
                       value=""
                       placeholder="End Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductPackage.export.updated_at_label')</label>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductPackage-updated_at-start"
                       name="ProductPackage[updated_at][start]"
                       value=""
                       placeholder="Start Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductPackage-updated_at-end"
                       name="ProductPackage[updated_at][end]"
                       value=""
                       placeholder="End Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductPackage.export.active_label')<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductPackage-active-all" name="ProductPackage[active]" value="" checked />
                    <label class="custom-control-label" for="ProductPackage-active-all">@lang('MinmaxProduct::io.ProductPackage.export.options.active.all')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductPackage-active-1" name="ProductPackage[active]" value="1" />
                    <label class="custom-control-label" for="ProductPackage-active-1">@lang('MinmaxProduct::io.ProductPackage.export.options.active.1')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductPackage-active-0" name="ProductPackage[active]" value="0" />
                    <label class="custom-control-label" for="ProductPackage-active-0">@lang('MinmaxProduct::io.ProductPackage.export.options.active.0')</label>
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
        $('#exportForm').validate({
            submitHandler: function(form) {
                form.submit();
                setTimeout(function () { window.location.reload(true); }, 1000);
            }
        });
    });
})(jQuery);
</script>
@endpush