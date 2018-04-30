<?php

Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(__(explode('_', auth()->guard()->getName())[1] . '.breadcrumbs.home'), route('home'));
});