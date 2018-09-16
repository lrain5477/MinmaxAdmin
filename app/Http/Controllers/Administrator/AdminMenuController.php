<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Administrator\AdminMenuRepository;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function __construct(Request $request, AdminMenuRepository $adminMenuRepository)
    {
        $this->modelRepository = $adminMenuRepository;

        parent::__construct($request);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->modelRepository
            ->query()
            ->where('parent_id', request('parent', null));
    }

    /**
     * Administrator AdminMenu DataGrid List.
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        $parentModel = $this->modelRepository->find(request('parent', null)) ?? abort(404);

        $this->viewData['menuParent'] = $parentModel->guid;
        $this->viewData['menuParentBack'] = $parentModel->parent_id;

        return parent::index();
    }
}
