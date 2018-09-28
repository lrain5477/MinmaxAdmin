<?php

namespace App\Mail;

use App\Models\NewsletterSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $model;

    /**
     * Create a new message instance.
     *
     * @param  NewsletterSchedule $model
     * @return void
     */
    public function __construct(NewsletterSchedule $model)
    {
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->model->subject)
            ->html($this->model->content);
    }
}
