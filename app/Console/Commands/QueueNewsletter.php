<?php

namespace App\Console\Commands;

use App\Mail\NewsletterMail;
use App\Models\NewsletterSchedule;
use App\Models\NewsletterSubscribe;
use Illuminate\Console\Command;

class QueueNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto push newsletter to queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newsletters = NewsletterSchedule::query()
            ->where('schedule_at', '<=', date('Y-m-d H:i:s'))
            ->whereRaw("`id` not in (select `schedule_id` from `newsletter_record` where `action` = 'sent' group by `schedule_id`)")
            ->get();

        $recordInsert = [];

        foreach ($newsletters as $newsletter) {
            /** @var NewsletterSchedule $newsletter */
            $subscribers = NewsletterSubscribe::query()
                ->where(function($query) use ($newsletter) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    if (is_array($newsletter->groups) && count($newsletter->groups) > 0) {
                        $query->whereRaw("`email` in (select `group_id` from `newsletter_group_subscribe` where `group_id` in (" . implode(',', $newsletter->groups) . "))");
                    }
                })
                ->get();

            foreach ($subscribers as $subscriber) {
                /** @var NewsletterSubscribe $subscriber */
                \Mail::to($subscriber->email)->queue((new NewsletterMail($newsletter))->onQueue('emails'));

                $recordInsert[] = [
                    'schedule_id' => $newsletter->id,
                    'email' => $subscriber->email,
                    'action' => 'sent',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        if (count($recordInsert) > 0) {
            \DB::table('newsletter_record')->insert($recordInsert);
        }

        $this->info('Queue newsletter success.');
    }
}
