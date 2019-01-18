<?php

namespace Minmax\Base\Admin;

/**
 * Class RoleController
 */
class RoleController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(RoleRepository $repository)
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

                    if ($column == 'display_name') {
                        try {
                            $filterDisplayName = collect(cache('langMap.' . app()->getLocale(), []))
                                ->filter(function ($item, $key) use ($value) {
                                    return preg_match('/^roles\.display_name\./', $key) > 0 && strpos($item, $value) !== false;
                                })
                                ->keys()
                                ->toArray();
                            $query->orWhereIn($column, $filterDisplayName);
                        } catch (\Exception $e) {}
                        continue;
                    }

                    $query->orWhere($column, 'like', "%{$value}%");
                }
            }

            if($request->has('equal')) {
                foreach($request->input('equal', []) as $column => $value) {
                    if (empty($column) || is_null($value) || $value === '') continue;

                    $query->where($column, $value);
                }
            }
        });

        return $datatable;
    }
}
