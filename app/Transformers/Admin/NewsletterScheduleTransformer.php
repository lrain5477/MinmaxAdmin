<?php

namespace App\Transformers\Admin;

use App\Models\NewsletterSchedule;

class NewsletterScheduleTransformer extends Transformer
{
    protected $model = 'NewsletterSchedule';
    protected $parameterSet = [];

    /**
     * Transformer constructor. Put action permissions.
     *
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(request()->user('admin')->can('newsletterScheduleShow')) $this->permissions[] = 'R';
        if(request()->user('admin')->can('newsletterScheduleEdit')) $this->permissions[] = 'U';
        if(request()->user('admin')->can('newsletterScheduleDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param NewsletterSchedule $model
     * @return array
     * @throws \Throwable
     */
    public function transform(NewsletterSchedule $model)
    {
        return [
            'title' => $this->getGridText($model->title),
            'subject' => $this->getGridText($model->subject),
            'schedule_at' => $this->getGridText($model->schedule_at),
            'action' => $this->getGridActions($model->id),
        ];
    }
}