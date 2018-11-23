<?php
try {

    Breadcrumbs::register('web.home', function ($breadcrumbs) {
        /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
        $breadcrumbs->push(__('MinmaxBase::web.breadcrumbs.home'), langRoute('web.home'));
    });

} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {}
