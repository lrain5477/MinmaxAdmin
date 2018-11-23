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
        if ($parent_id = request('parent')) {
            return parent::getQueryBuilder()->where('parent_id', $parent_id);
        } else {
            return parent::getQueryBuilder()->whereNull('parent_id');
        }
    }

    /**
     * Administrator AdminMenu DataGrid List.
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        $this->viewData['parentModel'] = $this->modelRepository->one('guid', request('parent'));

        return parent::index();
    }
}
