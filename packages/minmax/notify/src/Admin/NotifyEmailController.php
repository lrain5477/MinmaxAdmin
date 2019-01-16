<?php

namespace Minmax\Notify\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class NotifyEmailController
 */
class NotifyEmailController extends Controller
{
    protected $packagePrefix = 'MinmaxNotify::';

    public function __construct(NotifyEmailRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }
}
