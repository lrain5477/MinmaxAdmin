<?php
/**
 * @var string $placeholder
 * @var string $slot
 */
?>
<div class="col-md-auto">
    <div class="dataTablesSearch row no-gutters">
        <label class="col-auto mr-2"><i class="icon-search i-o align-middle h3 mb-0 p-0"></i>@lang('MinmaxBase::administrator.grid.search')</label>
        <div class="col col-md-auto mr-1">
            <input class="form-control form-control-sm table-search-input" type="search" placeholder="{{ $placeholder ?? '' }}" aria-controls="tableList" id="sch_keyword" name="sch_keyword"/>
        </div>
        <div class="col-auto mr-1">
            <select class="bs-select form-control" id="sch_column" data-style="btn-outline-light btn-sm min-w-select small">
                {{ $slot }}
            </select>
        </div>
    </div>
</div>