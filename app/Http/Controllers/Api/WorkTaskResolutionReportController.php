<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WorkTaskResolutionReportRequest;
use App\Http\Resources\WorkTaskResolutionReportResource;
use App\Services\WorkTaskResolutionReportService;

class WorkTaskResolutionReportController extends Controller
{
    public function __invoke(
        WorkTaskResolutionReportRequest $workTaskResolutionReportRequest,
        WorkTaskResolutionReportService $workTaskResolutionReportService
    ): WorkTaskResolutionReportResource {
        return new WorkTaskResolutionReportResource(
            $workTaskResolutionReportService->getResolutionTypeCounts(
                $workTaskResolutionReportRequest->validated('from'),
                $workTaskResolutionReportRequest->validated('to')
            )
        );
    }
}
