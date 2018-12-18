<?php
/**
 * @var \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\WorldLanguage[] $languageActive
 */
?>
<div class="float-right">
    {{ $slot }}

    @if(isset($languageActive) && $languageActive->count() > 1)
    <div class="btn-group btn-group-sm dropdown" role="group">
        <button class="btn dropdown-toggle btn-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="@lang('MinmaxBase::admin.form.language')" id="tableLen">
            <i class="icon-globe"></i><span class="ml-1 d-none d-md-inline-block">{{ $languageActive->where('current', true)->first()->name }}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="tableLen">
            @foreach($languageActive as $language)
            <a class="form-local-option dropdown-item {{ $language->current  ? 'selected' : '' }}"
               data-code="{{ $language->code }}"
               data-url="{{ langRoute('admin.setFormLocal') }}"
               href="javascript:void(0);">{{ $language->name }}</a>
            @endforeach
        </div>
    </div>
    @endif
</div>