<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use App\Models\ResolutionType;
use App\Models\Call;
use App\Models\WorkTask;
use App\Http\Controllers\Api\WorkTaskResolutionReportController;
use App\Enums\CallStage;
use Illuminate\Support\Facades\DB;

class WorkTaskResolutionReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/reports/work-tasks/resolutions', WorkTaskResolutionReportController::class);
    }

    public function test_returns_resolution_type_counts_within_date_range()
    {
        $from = now()->subDays(10)->format('Y-m-d');
        $to = now()->format('Y-m-d');

        $resolutionA = ResolutionType::factory()->create(['name' => 'A']);
        $resolutionB = ResolutionType::factory()->create(['name' => 'B']);

        $call1 = Call::factory()->create(['stage' => 'Completed']);
        $call2 = Call::factory()->create(['stage' => 'Completed']);

        // create work tasks for resolution A (2 tasks) and B (1 task) using factory
        WorkTask::factory()->create([
            'call_id' => $call1->id,
            'resolution_type_id' => $resolutionA->id,
            'created_at' => now()->subDays(5),
        ]);

        WorkTask::factory()->create([
            'call_id' => $call2->id,
            'resolution_type_id' => $resolutionA->id,
            'created_at' => now()->subDays(3),
        ]);

        WorkTask::factory()->create([
            'call_id' => $call2->id,
            'resolution_type_id' => $resolutionB->id,
            'created_at' => now()->subDays(4),
        ]);

        $response = $this->getJson('/reports/work-tasks/resolutions?from='.$from.'&to='.$to);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['resolution_types' => [['id', 'name', 'description', 'count']]]]);

        $data = $response->json('data.resolution_types');

        $this->assertCount(2, $data);

        $counts = collect($data)->pluck('count', 'name')->all();

        $this->assertEquals(2, $counts['A']);
        $this->assertEquals(1, $counts['B']);
    }

    public function test_validation_requires_from_and_to_dates()
    {
        $response = $this->getJson('/reports/work-tasks/resolutions');

        $response->assertStatus(422);
    }

    public function test_returns_empty_when_no_work_tasks_match()
    {
        $from = now()->subDays(10)->format('Y-m-d');
        $to = now()->format('Y-m-d');

        // create a resolution type but no work tasks
        ResolutionType::factory()->create(['name' => 'Z']);

        $response = $this->getJson('/reports/work-tasks/resolutions?from='.$from.'&to='.$to);

        $response->assertStatus(200);
        $this->assertEmpty($response->json('data.resolution_types'));
    }

    public function test_excludes_work_tasks_where_call_stage_is_excluded()
    {
        $from = now()->subDays(10)->format('Y-m-d');
        $to = now()->format('Y-m-d');

        $resolution = ResolutionType::factory()->create(['name' => 'ExcludedCase']);

        // insert a call with an excluded stage value (Archived)
        $callId = DB::table('calls')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
            'stage' => CallStage::Archived->value ?? 'Archived',
        ]);

        WorkTask::factory()->create([
            'call_id' => $callId,
            'resolution_type_id' => $resolution->id,
            'created_at' => now()->subDays(2),
        ]);

        $response = $this->getJson('/reports/work-tasks/resolutions?from='.$from.'&to='.$to);

        $response->assertStatus(200);
        $this->assertEmpty($response->json('data.resolution_types'));
    }

    public function test_includes_tasks_on_date_boundaries_and_orders_by_name()
    {
        $fromDate = now()->subDays(5)->format('Y-m-d');
        $toDate = now()->format('Y-m-d');

        $resA = ResolutionType::factory()->create(['name' => 'Alpha']);
        $resB = ResolutionType::factory()->create(['name' => 'Beta']);

        $callId = DB::table('calls')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
            'stage' => CallStage::Completed->value ?? 'Completed',
        ]);

        // created exactly at from 00:00:00 and to 23:59:59
        WorkTask::factory()->create([
            'call_id' => $callId,
            'resolution_type_id' => $resB->id,
            'created_at' => "{$fromDate} 00:00:00",
        ]);

        WorkTask::factory()->create([
            'call_id' => $callId,
            'resolution_type_id' => $resA->id,
            'created_at' => "{$toDate} 23:59:59",
        ]);

        $response = $this->getJson('/reports/work-tasks/resolutions?from='.$fromDate.'&to='.$toDate);

        $response->assertStatus(200);

        $names = collect($response->json('data.resolution_types'))->pluck('name')->all();

        // ordering should be alphabetical by name: Alpha then Beta
        $this->assertEquals(['Alpha', 'Beta'], $names);
    }
}
