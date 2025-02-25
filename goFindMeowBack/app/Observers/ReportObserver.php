<?php
namespace App\Observers;

use App\Models\Report;


class ReportObserver
{
   
    public function created(Report $report)
    {
        // Minden rekordot átvizsgálunk, ahol az activity 1, és a created_at értéke 14 napnál régebbi
        $reports = Report::where('activity', 1)
            ->where('created_at', '<=', now()->subDays(14))
            ->get();

        foreach ($reports as $report) {
            // Frissítjük az activity mezőt 0-ra
            $report->update(['activity' => 0]);
        }
    }
}
