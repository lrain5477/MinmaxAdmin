<?php

namespace Minmax\Base\Administrator;

/**
 * Class LoginLogController
 */
class LoginLogController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(LoginLogRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    protected function getQueryBuilder()
    {
        return $this->modelRepository->query()
            ->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-3 months')));
    }
}
