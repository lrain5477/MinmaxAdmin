<?php

namespace Minmax\Article\Admin;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Minmax\Base\Admin\Controller;

/**
 * Class ArticleCategoryController
 */
class ArticleCategoryController extends Controller
{
    protected $packagePrefix = 'MinmaxArticle::';

    public function __construct(ArticleCategoryRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    protected function setCustomViewDataIndex()
    {
        $this->viewData['parentModel'] = $this->modelRepository->one('id', request('parent'));
    }

    protected function setCustomViewDataCreate()
    {
        $this->viewData['formData']->parent_id = request('parent');
    }

    /**
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsIndex()
    {
        Breadcrumbs::register('datatable', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $this->modelRepository->setBreadcrumbs($breadcrumbs, $this->uri, request('parent'));
        });

        return parent::buildBreadcrumbsIndex();
    }

    protected function getQueryBuilder()
    {
        $query = $this->modelRepository->query()->withCount('articleNews');

        if ($parent_id = request('parent')) {
            return $query->where('parent_id', $parent_id);
        } else {
            return $query->whereNull('parent_id');
        }
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
                $query->where(function ($query) use ($request) {
                    /** @var \Illuminate\Database\Query\Builder $query */

                    foreach ($request->input('filter', []) as $column => $value) {
                        if (empty($column) || is_null($value) || $value === '') continue;

                        if ($column == 'title') {
                            try {
                                $filterTitle = collect(cache('langMap.' . app()->getLocale(), []))
                                    ->filter(function ($item, $key) use ($value) {
                                        return preg_match('/^article_category\.title\./', $key) > 0 && strpos($item, $value) !== false;
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

                    $query->where($column, $value);
                }
            }
        });

        $titleLanguageSet = collect(langDBSet('article_category.title.'))->sort()->keys()->implode("','");
        $datatable->orderColumn('title', "field(title,'{$titleLanguageSet}') $1");

        return $datatable;
    }
}
