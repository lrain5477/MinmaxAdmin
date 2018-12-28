<?php

namespace Minmax\Base\Administrator;

/**
 * Class EditorTemplateController
 */
class EditorTemplateController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(EditorTemplateRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
