<?php

namespace App\Console\Commands;

use App\MentorReport;
use App\Report;
use DateTime;
use Illuminate\Console\Command;

class checkMentorReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mentorReports:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the status of mentor reports, should they be sent or not.';

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
        $counter = 0;
        $reports = MentorReport::all()->load('file_groups');
        foreach($reports as $report) {
            if($report->file_groups()->count() == 0) {
                $dtNow = new DateTime(now());
                $dtCheck = new DateTime($report->contract_check);
                $diff = date_diff($dtCheck,$dtNow)->format('%R%a');
                if($diff <= 5 && $diff >= -5) {
                    if($report->status != Report::$WARNING) {
                        $report->status = Report::$WARNING;
                        $report->save();
                        $counter++;
                    }

                } else if($diff > 5) {
                    $report->status = Report::$LATE;
                    if($report->status != Report::$LATE) {
                        $report->save();
                        $counter++;
                    }
                }
            } else {
                if($report->status != Report::$SENT) {
                    $report->status = Report::$SENT;
                    $report->save();
                }
            }
        }
        return $counter;
    }
}
