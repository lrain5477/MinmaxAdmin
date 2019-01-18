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
     * @param  mixed $datatable
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function doDatatableFilter($datatable, $request)
    {
        $datatable->filter(function($query) use ($request) {
            /** @var \Illuminate\Database\Query\Builder $query */

            if($request->has('filter')) {
                foreach ($request->input('filter', []) as $column => $value) {
                    if (empty($column) || is_null($value) || $value === '') continue;

                    $query->orWhere($column, 'like', "%{$value}%");
                }
            }

            if($request->has('equal')) {
                foreach($request->input('equal', []) as $column => $value) {
                    if (empty($column) || is_null($value) || $value === '') continue;

                    if($column == 'role_id') {
                        $query->whereRaw('`id` in (select `user_id` from `role_user` where `role_id` = ?)', [$value]);
                        continue;
                    }

                    $query->where($column, $value);
                }
            }
        });

        return $datatable;
    }
}
