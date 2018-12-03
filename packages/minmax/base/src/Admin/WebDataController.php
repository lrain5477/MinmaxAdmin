<?php

namespace Minmax\Base\Admin;

class WebDataController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(WebDataRepository $webDataRepository)
    {
        $this->modelRepository = $webDataRepository;

        parent::__construct();
    }
}
