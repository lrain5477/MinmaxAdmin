<?php

Breadcrumbs::register('administrator.home', function ($breadcrumbs) {
    $breadcrumbs->push(__('administrator.breadcrumbs.home'), langRoute('administrator.home'));
});

Breadcrumbs::register('admin.home', function ($breadcrumbs) {
    $breadcrumbs->push(__('admin.breadcrumbs.home'), langRoute('admin.home'));
});