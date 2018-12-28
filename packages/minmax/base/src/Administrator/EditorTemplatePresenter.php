<?php

namespace Minmax\Base\Administrator;

/**
 * Class EditorTemplatePresenter
 */
class EditorTemplatePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['title', 'description', 'editor'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'guard' => [
                'administrator' => ['title' => 'Administrator', 'options' => []],
                'admin' => ['title' => 'Admin', 'options' => []],
                'web' => ['title' => 'Web', 'options' => []],
            ],
            'active' => systemParam('active'),
        ];
    }
}