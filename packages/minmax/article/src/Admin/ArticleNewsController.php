<?php

namespace Minmax\Article\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class ArticleNewsController
 */
class ArticleNewsController extends Controller
{
    protected $packagePrefix = 'MinmaxArticle::';

    public function __construct(ArticleNewsRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    protected function getQueryBuilder()
    {
        return $this->modelRepository->query()->with('articleCategories');
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
            /** @var \Illuminate\Database\Eloquent\Builder $query */

            if($request->has('filter')) {
                $query->where(function ($query) use ($request) {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */

                    foreach ($request->input('filter', []) as $column => $value) {
                        if (empty($column) || is_null($value) || $value === '') continue;

                        if ($column == 'title') {
                            try {
                                $filterTitle = collect(cache('langMap.' . app()->getLocale(), []))
                                    ->filter(function ($item, $key) use ($value) {
                                        return preg_match('/^article_news\.title\./', $key) > 0 && strpos($item, $value) !== false;
                                    })
                                    ->keys()
                                    ->toArray();
                                $query->orWhereIn($column, $filterTitle);
                            } catch (\Exception $e) {}
                            continue;
                        }

                        $query->orWhere($column, 'like', "%{$value}%");
                    }
                });
            }

            if($request->has('equal')) {
                foreach($request->input('equal', []) as $column => $value) {
                    if (empty($column) || is_null($value) || $value === '') continue;

                    if ($column == 'category') {
                        $query
                            ->whereHas('articleCategories', function ($query) use ($value) {
                                /** @var \Illuminate\Database\Eloquent\Builder $query */
                                $query->where('id', $value);
                            });
                        continue;
                    }

                    $query->where($column, $value);
                }
            }
        });

        return $datatable;
    }
}
