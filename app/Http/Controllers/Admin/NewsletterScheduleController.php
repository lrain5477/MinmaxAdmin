<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\NewsletterScheduleRepository;
use App\Repositories\Admin\NewsletterTemplateRepository;
use Illuminate\Http\Request;

class NewsletterScheduleController extends Controller
{
    public function __construct(Request $request, NewsletterScheduleRepository $newsletterScheduleRepository)
    {
        $this->modelRepository = $newsletterScheduleRepository;

        parent::__construct($request);
    }

    public function ajaxTemplate(Request $request, NewsletterTemplateRepository $newsletterTemplateRepository)
    {
        $this->checkPermissionCreate('ajax');

        $templateId = $request->get('id');

        $validator = validator(['id' => $templateId], ['id' => 'required|exists:newsletter_template,id']);

        if (!$validator->fails()) {
            if ($templateData = $newsletterTemplateRepository->find($templateId)) {
                return response(['msg' => 'success', 'template' => $templateData->toArray()], 200, ['Content-Type' => 'application/json']);
            }
        }

        return response(['msg' => 'error'], 300, ['Content-Type' => 'application/json']);
    }
}
