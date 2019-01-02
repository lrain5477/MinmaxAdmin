<?php

namespace Minmax\Io\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class IoConstructPresenter
 */
class IoConstructPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxIo::';

    protected $languageColumns = ['title', 'filename'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'import_enable' => systemParam('import_enable'),
            'export_enable' => systemParam('export_enable'),
            'active' => systemParam('active'),
        ];
    }
}