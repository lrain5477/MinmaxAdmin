<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\WebData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactRemind extends Mailable
{
    use Queueable, SerializesModels;

    protected $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $webData = WebData::first();

        return $this->view('emails.admin.contact-remind')
            ->subject('聯絡我們表單提交通知')
            ->with([
                'webData' => $webData,
                'contactSubject' => $this->contact->subject,
                'contactName' => $this->contact->name,
                'contactEmail' => $this->contact->email,
                'contactComment' => $this->contact->comment,
            ]);
    }
}
