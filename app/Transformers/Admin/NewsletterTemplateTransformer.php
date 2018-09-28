<?php

namespace App\Transformers\Admin;

use App\Models\NewsletterTemplate;

class NewsletterTemplateTransformer extends Transformer
{
    protected $model = 'NewsletterTemplate';
    protected $parameterSet = [];

    /**
     * Transformer constructor. Put action permissions.
     *
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(request()->user('admin')->can('newsletterTemplateShow')) $this->permissions[] = 'R';
        if(request()->user('admin')->can('newsletterTemplateEdit')) $this->permissions[] = 'U';
        if(request()->user('admin')->can('newsletterTemplateDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param NewsletterTemplate $model
     * @return array
     * @throws \Throwable
     */
    public function transform(NewsletterTemplate $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'subject' => $this->getGridText($model->subject),
            'created_at' => $this->getGridText($model->created_at),
            'action' => $this->getGridActions($model->id),
        ];
    }
}