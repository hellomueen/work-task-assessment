<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WorkTaskResolutionReportController;

Route::get('/reports/work-tasks/resolutions', WorkTaskResolutionReportController::class);
