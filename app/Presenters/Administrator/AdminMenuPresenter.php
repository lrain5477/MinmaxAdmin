<?php

namespace App\Presenters\Administrator;

use App\Repositories\Admin\AdminMenuRepository;

class AdminMenuPresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'active' => systemParam('active'),
            'parent_id' => (new AdminMenuRepository())
                ->all(['parent_id' => null])
                ->mapWithKeys(function($item) {
                    /** @var \App\Models\AdminMenu $item */
                    return [$item->guid => ['title' => $item->title, 'class' => null]];
                })
                ->prepend(['title' => '(' . __('administrator.grid.root') . ')', 'class' => null], '')
                ->toArray()
        ];
    }
}