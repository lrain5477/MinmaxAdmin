<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\WebDataRepository;
use Illuminate\Http\Request;

class WebDataController extends Controller
{
    public function __construct(Request $request, WebDataRepository $webDataRepository)
    {
        $this->modelRepository = $webDataRepository;

        parent::__construct($request);
    }
}
