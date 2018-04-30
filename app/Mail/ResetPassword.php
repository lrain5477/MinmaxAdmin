<?php

namespace App\Mail;

use App\Models\WebData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $passwordToken;

    /**
     * Create a new message instance.
     *
     * @param $passwordToken
     * @return void
     */
    public function __construct($passwordToken)
    {
        $this->passwordToken = $passwordToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $webData = WebData::first();

        return $this->view('emails.member.reset-password')
            ->subject('忘記密碼重設通知信')
            ->with([
                'webData' => $webData,
                'resetToken' => $this->passwordToken,
            ]);
    }
}
