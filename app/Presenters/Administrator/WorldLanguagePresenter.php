<?php

namespace App\Presenters\Administrator;

class WorldLanguagePresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }
}