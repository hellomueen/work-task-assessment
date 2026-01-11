<?php

namespace App\Services;

use App\Enums\CallStage;
use App\Models\ResolutionType;
use App\Models\WorkTask;
use Illuminate\Support\Collection;

class WorkTaskResolutionReportService
{
    public function getResolutionTypeCounts(string $fromDate, string $toDate): Collection
    {
        return ResolutionType::query()
            ->whereHas('workTasks', $activeWorkTasksInDateRange = function ($workTasks) use ($fromDate, $toDate) {
                $workTasks
                    ->whereHas('call', function ($call) {
                        $call->whereNotIn('stage', CallStage::excluded());
                    })
                    ->whereBetween('created_at', [
                        "{$fromDate} 00:00:00",
                        "{$toDate} 23:59:59",
                    ]);
            })
            ->withCount(['workTasks' => $activeWorkTasksInDateRange])
            ->orderBy('name')
            ->get();
    }
}
