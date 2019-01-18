<?php

namespace Minmax\Base\Admin;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

/**
 * Class WebMenuController
 */
class WebMenuController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(WebMenuRepository $repository)
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

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQueryBuilder()
    {
        if ($parent_id = request('parent')) {
            return parent::getQueryBuilder()->where('parent_id', $parent_id);
        } else {
            return parent::getQueryBuilder()->whereNull('parent_id');
        }
    }
}
