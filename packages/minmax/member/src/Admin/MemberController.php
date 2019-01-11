<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class MemberController
 */
class MemberController extends Controller
{
    protected $packagePrefix = 'MinmaxMember::';

    public function __construct(MemberRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * Set datatable filter.
     *
     * @param  mixed $datatables
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function doDatatableFilter($datatables, $request)
    {
        if($request->has('filter') || $request->has('equal')) {
            $datatables->filter(function($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $whereQuery = '';
                $whereValue = [];

                if($request->has('filter')) {
                    foreach ($request->input('filter') as $column => $value) {
                        if (is_null($value) || $value === '') continue;

                        $whereQuery .= ($whereQuery === '' ? '' : ' or ') . "{$column} like ?";
                        $whereValue[] = "%{$value}%";
                    }
                    if($whereQuery !== '') $whereQuery = "({$whereQuery})";
                }

                if($request->has('equal')) {
                    foreach($request->input('equal') as $column => $value) {
                        if(is_null($value) || $value === '') continue;

                        if($column == 'role_id') {
                            $whereQuery .= ($whereQuery === '' ? '' : ' and ') . '`id` in (select `user_id` from `role_user` where `role_id` = ?)';
                            $whereValue[] = "{$value}";
                            continue;
                        }

                        $whereQuery .= ($whereQuery === '' ? '' : ' and ') . "{$column} = ?";
                        $whereValue[] = "{$value}";
                    }
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables;
    }
}
