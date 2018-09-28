<?php

namespace App\Presenters\Admin;

use App\Repositories\Admin\NewsletterGroupRepository;
use App\Repositories\Admin\NewsletterTemplateRepository;

class NewsletterSchedulePresenter extends Presenter
{
    public function __construct(NewsletterTemplateRepository $newsletterTemplateRepository, NewsletterGroupRepository $newsletterGroupRepository)
    {
        parent::__construct();

        $this->parameterSet = [
            'templates' => $newsletterTemplateRepository
                ->all(),
            'groups' => $newsletterGroupRepository->all()
                ->mapWithKeys(function($item) {
                    /** @var \App\Models\NewsletterGroup $item */
                    return [$item->id => ['title' => $item->title, 'class' => null]];
                })
                ->toArray(),
            'objects' => [],
        ];
    }

    public function getFieldTemplateSelection()
    {
        return view('admin.newsletter-schedule.template-selection', ['items' => $this->parameterSet['templates'] ?? collect()]);
    }
}