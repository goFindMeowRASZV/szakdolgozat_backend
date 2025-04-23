<?php
namespace App\Observers;

use App\Models\Report;


class ReportObserver
{
   
    public function created(Report $report)
    {
        $reports = Report::where('activity', 1)
            ->where('created_at', '<=', now()->subDays(14))
            ->get();

        foreach ($reports as $report) {
            $report->update(['activity' => 0]);
        }
    }
}
