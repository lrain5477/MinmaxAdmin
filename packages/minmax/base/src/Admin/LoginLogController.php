<?php

namespace Minmax\Base\Admin;

class LoginLogController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    protected function getQueryBuilder()
    {
        return \DB::table('login_log')
            ->where('guard', 'admin')
            ->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-3 months')))
            ->select(['username', 'ip', 'remark', 'result', 'created_at']);
    }

    protected function setDatatablesTransformer($datatables)
    {
        return $datatables;
    }
}
