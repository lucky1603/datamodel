<?php

namespace App\Console\Commands;

use App\Business\Profile;
use App\Business\Program;
use Illuminate\Console\Command;

class ResetCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resetCache {resetStatistic=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset programs and profile cache';

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
     * @return int
     */
    public function handle()
    {
        // Reset Profiles Cache
        if($this->argument("resetStatistic") != 0) {
            Profile::makeCache(true);
        } else {
            Profile::makeCache();
        }

        // Reset Programs Cache
        Program::makeCache();

        return 0;
    }
}
