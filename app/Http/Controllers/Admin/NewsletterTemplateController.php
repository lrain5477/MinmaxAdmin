<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\NewsletterTemplateRepository;
use Illuminate\Http\Request;

class NewsletterTemplateController extends Controller
{
    public function __construct(Request $request, NewsletterTemplateRepository $newsletterTemplateRepository)
    {
        $this->modelRepository = $newsletterTemplateRepository;

        parent::__construct($request);
    }
}
