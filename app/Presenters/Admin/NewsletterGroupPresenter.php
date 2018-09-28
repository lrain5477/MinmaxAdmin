<?php

namespace App\Presenters\Admin;

class NewsletterGroupPresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [];
    }
}