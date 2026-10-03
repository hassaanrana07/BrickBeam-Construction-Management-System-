<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $portfolios = Portfolio::all();
        $admin = User::first();

        if ($portfolios->isEmpty() || !$admin) {
            return;
        }

        $p1 = $portfolios->first();
        $p2 = $portfolios->count() > 1 ? $portfolios->get(1) : $p1;
        $p3 = $portfolios->count() > 2 ? $portfolios->get(2) : $p1;

        $tasks = [
            // To Do
            [
                'title' => 'Seismic Shear Wall Rebar Placement Inspection',
                'portfolio_id' => $p1->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->addDays(5)->toDateString(),
                'priority' => 'high',
                'status' => 'todo',
                'description' => 'Verify rebar spacing, lap splice lengths, and mechanical coupler certifications on Core Shear Wall C-3 before concrete placement.'
            ],
            [
                'title' => 'Post-Tension Tendon Stress Testing Protocol',
                'portfolio_id' => $p2->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->addDays(7)->toDateString(),
                'priority' => 'medium',
                'status' => 'todo',
                'description' => 'Calibrate hydraulic jacks and record elongation measurements against theoretical structural elongation tolerances.'
            ],
            [
                'title' => 'MEP Riser Shaft BIM Clash Reconciliation',
                'portfolio_id' => $p3->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->addDays(10)->toDateString(),
                'priority' => 'low',
                'status' => 'todo',
                'description' => 'Coordinate with HVAC and electrical subcontractors to resolve 35mm ductwork clearance conflict at Level 18.'
            ],

            // In Progress
            [
                'title' => 'Level 24 Core Wall Slipform Concrete Pour',
                'portfolio_id' => $p1->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->addDays(2)->toDateString(),
                'priority' => 'high',
                'status' => 'in_progress',
                'description' => 'Continuous 14-hour slipform pour operation with slump test verifications every 50 cubic meters.'
            ],
            [
                'title' => 'Structural Steel Bolt Torque Certification',
                'portfolio_id' => $p2->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->addDays(3)->toDateString(),
                'priority' => 'medium',
                'status' => 'in_progress',
                'description' => 'Calibrated torque wrench audit of Grade 10.9 high-strength structural bolts on cantilever trusses.'
            ],
            [
                'title' => 'Curtain Wall Unitized Glazing Anchor Verification',
                'portfolio_id' => $p3->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->addDays(4)->toDateString(),
                'priority' => 'high',
                'status' => 'in_progress',
                'description' => 'Laser telemetry check of embed plate coordinates prior to hoisting 3-story glass panels.'
            ],

            // Completed
            [
                'title' => 'Subterranean Caisson Piling Phase 1 Completion',
                'portfolio_id' => $p1->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->subDays(5)->toDateString(),
                'priority' => 'high',
                'status' => 'completed',
                'completed_at' => now()->subDays(4),
                'description' => 'All 48 micropiles drilled to bedrock refusal and pressure-grouted with sonic integrity testing passed.'
            ],
            [
                'title' => 'Tower Crane 2 Foundation Anchor Certification',
                'portfolio_id' => $p2->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->subDays(10)->toDateString(),
                'priority' => 'high',
                'status' => 'completed',
                'completed_at' => now()->subDays(8),
                'description' => 'Third-party OSHA engineering sign-off on 280 EC-H tower crane foundation tie-down anchors.'
            ],
            [
                'title' => 'Mat Slab Concrete Core Thermal Gradient Logging',
                'portfolio_id' => $p3->id,
                'assigned_to' => $admin->id,
                'deadline' => now()->subDays(14)->toDateString(),
                'priority' => 'medium',
                'status' => 'completed',
                'completed_at' => now()->subDays(12),
                'description' => 'Thermocouple sensors verified internal concrete core temperature stayed below 70°C hydration threshold.'
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::updateOrCreate(
                ['title' => $taskData['title'], 'portfolio_id' => $taskData['portfolio_id']],
                $taskData
            );
        }
    }
}
