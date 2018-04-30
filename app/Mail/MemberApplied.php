<?php

namespace App\Mail;

use App\Models\Member;
use App\Models\WebData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberApplied extends Mailable
{
    use Queueable, SerializesModels;

    protected $member;

    /**
     * Create a new message instance.
     *
     * @param $member
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

        return $this->view('emails.member.member-applied')
            ->subject('會員申請審核結果通知信')
            ->with([
                'webData' => $webData,
                'memberName' => $this->member->name,
                'memberUsername' => $this->member->username,
                'memberAppliedAt' => $this->member->applied_at,
            ]);
    }
}
