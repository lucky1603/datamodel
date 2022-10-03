<?php

namespace App\Console\Commands;

use App\Report;
use DateTime;
use Illuminate\Console\Command;

class checkReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the reports in order to change their statuses';

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
    public function handle(): int
    {
        $counter = 0;
        $reports = Report::all()->load('file_groups');
        foreach($reports as $report) {
            if($report->synchronized == 0)
                continue;
            if($report->file_groups->count() === 0) {
                $dtNow = new DateTime(now());
                $dtCheck = new DateTime($report->contract_check);
                $diff = date_diff($dtCheck,$dtNow)->format('%R%a');

                $programId = $report->getProgram()->getId();
                // echo "Program - ".$programId.", date difference is ".$diff." days, report status is ".$report->status."\n";
                if($diff <= 0 && $diff >= -5) {
                    if($report->status != Report::$WARNING) {
                        $report->status = Report::$WARNING;
                        $report->save();
                        $counter++;
                    }

                } else if($diff > 0) {
                    if($report->status != Report::$LATE) {
                        $report->status = Report::$LATE;
                        $report->save();
                        $counter++;
                    }
                } else {
                    $report->status = Report::$SCHEDULED;
                    $report->save();
                    $counter++;
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
