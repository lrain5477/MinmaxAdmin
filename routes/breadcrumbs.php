<?php

Breadcrumbs::register('administrator.home', function ($breadcrumbs) {
    $breadcrumbs->push(__('administrator.breadcrumbs.home'), route('administrator.home'));
});

Breadcrumbs::register('admin.home', function ($breadcrumbs) {
    $breadcrumbs->push(__('admin.breadcrumbs.home'), route('admin.home'));
});

Breadcrumbs::register('merchant.home', function ($breadcrumbs) {
    $breadcrumbs->push(__('merchant.breadcrumbs.home'), route('merchant.home'));
});