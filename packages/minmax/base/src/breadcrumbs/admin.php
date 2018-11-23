<?php
try {

    Breadcrumbs::register('admin.home', function ($breadcrumbs) {
        /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
        $breadcrumbs->push(__('MinmaxBase::admin.breadcrumbs.home'), langRoute('admin.home'));
    });

} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {}
