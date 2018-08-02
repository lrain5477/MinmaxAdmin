<?php

namespace App\Mail;

use App\Models\WebData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $webData;
    protected $passwordToken;

    /**
     * Create a new message instance.
     *
     * @param $passwordToken
     * @return void
     */
    public function __construct($passwordToken)
    {
        $this->webData = WebData::where(['website_key' => 'web'])->first();
        $this->passwordToken = $passwordToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.member.reset-password')
            ->subject('忘記密碼重設通知函')
            ->with([
                'webData' => $this->webData,
                'resetUrl' => url("reset-password/{$this->passwordToken}"),
            ]);
    }
}
