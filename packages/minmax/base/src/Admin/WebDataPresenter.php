<?php

namespace Minmax\Base\Admin;

class WebDataPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['website_name', 'company', 'contact', 'seo', 'options', 'offline_text'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active', session('admin-formLocal', app()->getLocale())),
        ];
    }
}