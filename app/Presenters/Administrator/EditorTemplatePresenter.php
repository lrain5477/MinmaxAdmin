<?php

namespace App\Presenters\Administrator;

class EditorTemplatePresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'guard' => [
                'admin' => ['title' => 'admin', 'class' => null],
                'web' => ['title' => 'web', 'class' => null],
            ],
            'active' => systemParam('active'),
        ];
    }
}