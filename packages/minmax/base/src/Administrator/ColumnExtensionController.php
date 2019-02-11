<?php

namespace Minmax\Base\Administrator;

/**
 * Class ColumnExtensionController
 */
class ColumnExtensionController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(ColumnExtensionRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
