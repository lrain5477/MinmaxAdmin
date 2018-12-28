<?php

namespace Minmax\Base\Administrator;

/**
 * Class SystemLogController
 */
class SystemLogController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(SystemLogRepository $repository)
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
