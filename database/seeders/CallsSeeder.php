<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\CallStage;
use App\Models\Call;

class CallsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CallStage::cases() as $stage) {
            Call::factory()->count(2)->create(['stage' => $stage]);
        }
    }
}
