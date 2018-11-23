<?php
try {

    Breadcrumbs::register('administrator.home', function ($breadcrumbs) {
        /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
        $breadcrumbs->push(__('MinmaxBase::administrator.breadcrumbs.home'), langRoute('administrator.home'));
    });

} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {}
