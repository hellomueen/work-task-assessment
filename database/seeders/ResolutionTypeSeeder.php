<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResolutionType;

class ResolutionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resolutionTypes = [
            [
                'name' => 'Fix Complete - Parts Collection Required',
                'description' => 'Parts need to be collected',
            ],
            [
                'name' => 'Further Diagnosis - Internal - 3rd Party Repair',
                'description' => 'Requires additional diagnosis',
            ],
            [
                'name' => 'Awaiting Purchase Order from Customer',
                'description' => 'Awaiting more information',
            ],
            [
                'name' => 'Call on Hold at Customer\'s Request',
                'description' => 'Customer requested to wait',
            ],
        ];

        foreach ($resolutionTypes as $resolutionType) {
            ResolutionType::create($resolutionType);
        }
    }
}
