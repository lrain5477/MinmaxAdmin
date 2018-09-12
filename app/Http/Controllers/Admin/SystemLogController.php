<?php

namespace App\Http\Controllers\Admin;

class SystemLogController extends Controller
{
    protected function getQueryBuilder()
    {
        return \DB::table('system_log')
            ->where('guard', 'admin')
            ->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-3 months')))
            ->select(['uri', 'guid', 'username', 'ip', 'remark', 'result', 'created_at']);
    }

    protected function setDatatablesTransformer($datatables)
    {
        return $datatables;
    }
}
