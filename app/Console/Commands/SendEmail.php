<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {--limit=20}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email from custom queue list.';

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
        $queueAmount = \DB::table('jobs')->where('queue', 'emails')->count();
        $limit = $queueAmount > $this->option('limit') ? $this->option('limit') : $queueAmount;
        for ($i = 0; $i < $limit; $i++) {
            \Artisan::call('queue:work', ['--queue' => 'emails', '--once' => true, '--tries' => 2]);
        }

        $this->info(date('Y-m-d H:i:s') . ' Email sent success.');
    }
}
