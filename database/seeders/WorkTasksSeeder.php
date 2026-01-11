<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResolutionType;
use App\Models\Call;
use App\Models\WorkTask;

class WorkTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resolutionTypes = ResolutionType::all();
        $calls = Call::all();

        foreach ($calls as $call) {
            WorkTask::factory()->create([
                'call_id' => $call->id,
                'resolution_type_id' => $resolutionTypes->random()->id,
            ]);
        }
    }
}
