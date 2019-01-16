<?php

namespace Minmax\Notify\Administrator;

use Minmax\Base\Administrator\Controller;

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
