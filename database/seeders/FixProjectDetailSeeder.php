<?php

namespace Database\Seeders;

use App\Models\ProjectDetail;
use App\Models\ProjectScoreDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixProjectDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = ProjectScoreDetail::with('projectScore')->get();

        foreach ($details as $detail) {
            $projectId = $detail->projectScore?->project_id;

            if ($projectId) {
                $projectDetail = ProjectDetail::where('project_id', $projectId)->first();

                if ($projectDetail) {
                    $detail->project_detail_id = $projectDetail->id;
                    $detail->save();
                }
            }
        }
    }
}
