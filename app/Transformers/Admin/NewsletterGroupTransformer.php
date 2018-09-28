<?php

namespace App\Transformers\Admin;

use App\Models\NewsletterGroup;

class NewsletterGroupTransformer extends Transformer
{
    protected $model = 'NewsletterGroup';
    protected $parameterSet = [
        // 'active',
    ];

    /**
     * Transformer constructor. Put action permissions.
     *
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(request()->user('admin')->can('newsletterGroupShow')) $this->permissions[] = 'R';
        if(request()->user('admin')->can('newsletterGroupEdit')) $this->permissions[] = 'U';
        if(request()->user('admin')->can('newsletterGroupDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param NewsletterGroup $model
     * @return array
     * @throws \Throwable
     */
    public function transform(NewsletterGroup $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'created_at' => $this->getGridText($model->created_at),
            'action' => $this->getGridActions($model->id),
        ];
    }
}