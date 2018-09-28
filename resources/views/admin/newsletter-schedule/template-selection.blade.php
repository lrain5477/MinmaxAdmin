<?php
/**
 * @var \Illuminate\Database\Eloquent\Collection|\App\Models\NewsletterTemplate[] $items
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="newsletter-template">範本套用</label>
    <div class="col-sm-6">
        <div class="input-group">
            <select class="custom-select" id="newsletter-template">
                <option value="" selected>@lang('admin.form.select_default_title')</option>
                @foreach($items as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
            </select>
            <div class="input-group-prepend">
                <button class="btn btn-secondary" type="button" onclick="loadFromTemplate();">套用</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function loadFromTemplate() {
    (function($) {
        var templateId = $('#newsletter-template').val();
        if (templateId !== '') {
            $.ajax({
                url: '{{ langRoute('admin.newsletter-schedule.ajax.template') }}',
                data: {id: templateId},
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#NewsletterSchedule-subject').val(response.template.subject);
                    CKEDITOR.instances['NewsletterSchedule-content'].setData(response.template.content);

                }
            });
        }
    })(jQuery);
}
</script>
@endpush