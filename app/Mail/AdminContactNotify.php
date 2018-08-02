<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\WebData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminContactNotify extends Mailable
{
    use Queueable, SerializesModels;

    protected $webData;
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->webData = WebData::where(['website_key' => 'web'])->first();
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.admin.contact-notify')
            ->subject('系統通知：有一則聯絡我們表單已提交')
            ->with([
                'webData' => $this->webData,
                'contactSubject' => $this->contact->contactCategory->title,
                'contactName' => $this->contact->name,
                'contactEmail' => $this->contact->email,
                'contactComment' => $this->contact->content,
            ]);
    }
}
