<?php
/**
 * @var \Minmax\Base\Models\Role $formData
 * @var \Illuminate\Database\Eloquent\Collection[] $permissionData
 */
?>
<div class="form-group p-2">
    <div class="row">
        <div class="col-md-12">
            <div class="button-multiselect-box mb-3" style="margin-right: 0">
                <a class="permission-on-all btn btn-secondary btn-sm" href="#">@lang('MinmaxBase::admin.form.select_all')</a>
                <a class="permission-off-all btn btn-secondary btn-sm" href="#">@lang('MinmaxBase::admin.form.select_clear')</a>
            </div>
        </div>

        @foreach($permissionData as $groupSet)
            @if($loop->iteration % 2 == 1)
            <div class="col-12 mb-2">
                <div class="row">
            @endif
                    <div class="col-md-6 permission-set">
                        <div class="row">
                            <div class="col-4">
                                @if($firstItem = $groupSet->first())
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ignore-valid switch-set"
                                           type="checkbox"
                                           id="permission-set-{{ $loop->iteration }}" />
                                    <label class="custom-control-label"
                                           for="permission-set-{{ $loop->iteration }}">{{ explode(' [', $firstItem->display_name)[0] ?? '' }}</label>
                                </div>
                                @endif
                            </div>
                            <div class="col text-secondary">
                                @foreach($groupSet as $item)
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input class="custom-control-input ignore-valid permission-item"
                                           type="checkbox"
                                           name="Permission[]"
                                           id="permission-{{ $item->id }}"
                                           value="{{ $item->id }}"
                                           {{ $formData->hasPermission($item->name) ? 'checked' : '' }} />
                                    <label class="custom-control-label"
                                           for="permission-{{ $item->id }}">{{ $item->label }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
            @if($loop->iteration % 2 == 0)
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

@push('scripts')
<script>
(function() {
    $(function() {
        $('.permission-on-all').on('click', function() {
            $('.permission-item').prop('checked', true).change();
            return false;
        });
        $('.permission-off-all').on('click', function() {
            $('.permission-item').prop('checked', false).change();
            return false;
        });
        $('.switch-set').on('change', function() {
            var $this = $(this);
            $('.permission-item', $this.parents('.permission-set')).prop('checked', $this.prop('checked'));
        });
        $('.permission-item').on('change', function() {
            var $this = $(this);
            var $set = $this.parents('.permission-set');
            $('.switch-set', $set).prop('checked', $('.permission-item', $set).length === $('.permission-item:checked', $set).length);
        }).change();
    });
})(jQuery);
</script>
@endpush