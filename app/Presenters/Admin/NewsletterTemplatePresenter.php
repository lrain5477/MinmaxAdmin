<?php

namespace App\Presenters\Admin;

class NewsletterTemplatePresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [];
    }
}