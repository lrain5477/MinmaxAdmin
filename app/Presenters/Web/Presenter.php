<?php

namespace App\Presenters\Web;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class Presenter
{
    protected $defaultSortKey = 'sort_index';

    public function renderPagination(LengthAwarePaginator $result) {
        return $result->links('frontend.layouts._pagination');
    }
}