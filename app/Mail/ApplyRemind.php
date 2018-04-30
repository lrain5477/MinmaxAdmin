<?php

namespace App\Mail;

use App\Models\Member;
use App\Models\WebData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyRemind extends Mailable
{
    use Queueable, SerializesModels;

    protected $member;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $webData = WebData::first();

        return $this->view('emails.admin.apply-remind')
            ->subject('會員申請提交通知')
            ->with([
                'webData' => $webData,
                'memberName' => $this->member->name,
                'memberUsername' => $this->member->username,
                'memberCreatedAt' => $this->member->created_at,
            ]);
    }
}
