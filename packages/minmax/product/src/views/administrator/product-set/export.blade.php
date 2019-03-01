<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 * @var \Minmax\Io\Models\IoConstruct $formData
 */
?>

<form id="exportForm" class="form-horizontal exportForm"  name="exportForm"
      action="{{ langRoute("administrator.{$pageData->uri}.export", ['id' => $formData->id]) }}"
      method="post"
      enctype="multipart/form-data">
    @csrf

    <fieldset class="mt-4">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-3"></i>@lang('MinmaxProduct::io.fieldSet.filter')</legend>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductSet.export.created_at_label')</label>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductSet-created_at-start"
                       name="ProductSet[created_at][start]"
                       value=""
                       placeholder="Start Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductSet-created_at-end"
                       name="ProductSet[created_at][end]"
                       value=""
                       placeholder="End Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductSet.export.updated_at_label')</label>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductSet-updated_at-start"
                       name="ProductSet[updated_at][start]"
                       value=""
                       placeholder="Start Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control datepicker-birthdate" style="padding-left: 32px;"
                       id="ProductSet-updated_at-end"
                       name="ProductSet[updated_at][end]"
                       value=""
                       placeholder="End Date" />
                <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductSet.export.active_label')<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductSet-active-all" name="ProductSet[active]" value="" checked />
                    <label class="custom-control-label" for="ProductSet-active-all">@lang('MinmaxProduct::io.ProductSet.export.options.active.all')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductSet-active-1" name="ProductSet[active]" value="1" />
                    <label class="custom-control-label" for="ProductSet-active-1">@lang('MinmaxProduct::io.ProductSet.export.options.active.1')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductSet-active-0" name="ProductSet[active]" value="0" />
                    <label class="custom-control-label" for="ProductSet-active-0">@lang('MinmaxProduct::io.ProductSet.export.options.active.0')</label>
                </div>
            </div>
        </div>

    </fieldset>

    <fieldset class="mt-4">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-3"></i>@lang('MinmaxProduct::io.fieldSet.filter')</legend>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductSet.export.sort_label')<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-4">
                <select class="bs-select form-control" id="ProductSet-sort" name="ProductSet[sort]" data-size="6" required>
                    <option value="created_at" selected>@lang('MinmaxProduct::models.ProductSet.created_at')</option>
                    <option value="updated_at">@lang('MinmaxProduct::models.ProductSet.updated_at')</option>
                    <option value="sku">@lang('MinmaxProduct::models.ProductSet.sku')</option>
                    <option value="serial">@lang('MinmaxProduct::models.ProductSet.serial')</option>
                    <option value="active">@lang('MinmaxProduct::models.ProductSet.active')</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('MinmaxProduct::io.ProductSet.export.arrange_label')<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductSet-arrange-asc" name="ProductSet[arrange]" value="asc" checked />
                    <label class="custom-control-label" for="ProductSet-arrange-asc">@lang('MinmaxProduct::io.ProductSet.export.options.arrange.asc')</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" id="ProductSet-arrange-desc" name="ProductSet[arrange]" value="desc" />
                    <label class="custom-control-label" for="ProductSet-arrange-desc">@lang('MinmaxProduct::io.ProductSet.export.options.arrange.desc')</label>
                </div>
            </div>
        </div>

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::administrator.form.button.reset')" onclick="window.location.reload(true)">
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