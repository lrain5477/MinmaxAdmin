<?php

namespace App\Transformers\Admin;


use App\Models\NewsletterSubscribe;

class NewsletterSubscribeTransformer extends Transformer
{
    protected $model = 'NewsletterSubscribe';
    protected $parameterSet = [];

    /**
     * Transformer constructor. Put action permissions.
     *
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(request()->user('admin')->can('newsletterSubscribeDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param NewsletterSubscribe $model
     * @return array
     * @throws \Throwable
     */
    public function transform(NewsletterSubscribe $model)
    {
        return [
            'email' => $this->getGridText($model->email),
            'created_at' => $this->getGridText($model->created_at),
            'action' => $this->getGridActions($model->email),
        ];
    }
}