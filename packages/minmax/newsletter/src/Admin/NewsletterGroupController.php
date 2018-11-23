<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\NewsletterGroupRepository;
use Illuminate\Http\Request;

class NewsletterGroupController extends Controller
{
    public function __construct(Request $request, NewsletterGroupRepository $newsletterGroupRepository)
    {
        $this->modelRepository = $newsletterGroupRepository;

        parent::__construct($request);
    }
}
