<?php

namespace Minmax\Member\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Minmax\Base\Models\WebData;
use Minmax\Member\Models\Member;
use Minmax\Notify\Models\NotifyEmail;

class MemberRegisteredAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $notify;
    protected $webData;
    protected $member;

    /**
     * Create a new message instance.
     *
     * @param  NotifyEmail $notify
     * @param  Member $member
     * @return void
     */
    public function __construct(NotifyEmail $notify, Member $member)
    {
        $this->notify = $notify;
        $this->webData = WebData::where('guard', 'web')->first();
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $replacements = [
            '{[name]}' => $this->member->name,
            '{[websitePhone]}' => array_get($this->webData->contact ?? [], 'phone', ''),
            '{[websiteEmail]}' => array_get($this->webData->contact ?? [], 'email', ''),
            '{[websiteName]}' => $this->webData->website_name,
            '{[websiteUrl]}' => $this->webData->system_url,
        ];

        $html = str_replace(array_keys($replacements), $replacements, $this->notify->admin_editor);

        return $this
            ->subject($this->notify->admin_subject)
            ->view('MinmaxNotifyEmail::email.layouts.default')
            ->with([
                'notifyData' => [
                    'subject' => $this->notify->admin_subject,
                    'perheader' => $this->notify->admin_preheader,
                    'editor' => $html,
                ],
            ]);
    }
}
