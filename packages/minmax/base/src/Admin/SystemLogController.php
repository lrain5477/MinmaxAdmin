<?php

namespace Minmax\Base\Admin;

class SystemLogController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    protected function getQueryBuilder()
    {
        return \DB::table('system_log')
            ->where('guard', 'admin')
            ->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-3 months')))
            ->select(['uri', 'id', 'username', 'ip', 'remark', 'result', 'created_at']);
    }

    protected function setDatatablesTransformer($datatables)
    {
        return $datatables;
    }
}
