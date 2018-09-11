<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function ajaxDataTable(Request $request)
    {
        $this->checkPermissionShow('ajax');

        $queryBuilder = \DB::table('system_log')
            ->where('guard', 'admin')
            ->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-3 months')))
            ->select(['uri', 'guid', 'username', 'ip', 'remark', 'result', 'created_at']);

        $datatables = \DataTables::of($queryBuilder);

        if($request->has('filter') || $request->has('equal')) {
            $datatables->filter(function($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $whereQuery = '';
                $whereValue = [];
                if($request->has('filter')) {
                    foreach ($request->input('filter') as $column => $value) {
                        if (is_null($value) || $value === '') continue;
                        if ($whereQuery === '') {
                            $whereQuery .= "{$column} like ?";
                        } else {
                            $whereQuery .= " or {$column} like ?";
                        }
                        $whereValue[] = "%{$value}%";
                    }
                    if($whereQuery !== '') $whereQuery = "({$whereQuery})";
                }
                if($request->has('equal')) {
                    foreach($request->input('equal') as $column => $value) {
                        if(is_null($value) || $value === '') continue;
                        if($whereQuery === '') {
                            $whereQuery .= "{$column} = ?";
                        } else {
                            $whereQuery .= " and {$column} = ?";
                        }
                        $whereValue[] = "{$value}";
                    }
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables->make(true);
    }
}
