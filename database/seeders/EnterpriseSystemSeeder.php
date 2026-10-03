<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\Task;
use App\Models\Milestone;
use App\Models\Vendor;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EnterpriseSystemSeeder extends Seeder
{
    public function run(): void
    {
        // Read seed password from environment variable; in production, do not create default demo accounts if not set
        $seedPassword = env('SEED_USER_PASSWORD');

        if (empty($seedPassword)) {
            if (app()->isProduction()) {
                $this->command?->warn('Skipping demo user creation in production: SEED_USER_PASSWORD environment variable is not set.');
                $seedPassword = null;
            } else {
                $seedPassword = 'dev_brickbeam_local_password';
            }
        }

        // 1. Create Users for each Role if seed password is available
        $superAdmin = null;
        $manager = null;
        $staff = null;

        if ($seedPassword) {
            $superAdmin = User::updateOrCreate(
                ['email' => 'admin@brickbeam.com'],
                ['name' => 'Super Admin', 'password' => Hash::make($seedPassword)]
            );
            $superAdmin->assignRole('Super Admin');

            $manager = User::updateOrCreate(
                ['email' => 'manager@brickbeam.com'],
                ['name' => 'Project Manager John', 'password' => Hash::make($seedPassword)]
            );
            $manager->assignRole('Manager');

            $staff = User::updateOrCreate(
                ['email' => 'staff@brickbeam.com'],
                ['name' => 'Field Staff Mike', 'password' => Hash::make($seedPassword)]
            );
            $staff->assignRole('Staff');

            $financeManager = User::updateOrCreate(
                ['email' => 'finance.manager@brickbeam.com'],
                ['name' => 'Finance Manager Sarah', 'password' => Hash::make($seedPassword)]
            );
            $financeManager->assignRole('Finance Manager');

            $financeSupport = User::updateOrCreate(
                ['email' => 'finance.support@brickbeam.com'],
                ['name' => 'Finance Support Alex', 'password' => Hash::make($seedPassword)]
            );
            $financeSupport->assignRole('Finance Support');
        } else {
            $manager = User::first();
            $staff = User::first();
        }

        // 2. Assign Manager to some Projects
        $projects = Portfolio::take(5)->get();
        foreach ($projects as $project) {
            $project->update(['manager_id' => $manager->id]);

            // 3. Add Milestones
            Milestone::create([
                'portfolio_id' => $project->id,
                'title' => 'Structural Foundation',
                'deadline' => now()->addWeeks(2),
                'status' => 'pending'
            ]);

            // 4. Add Tasks
            Task::create([
                'portfolio_id' => $project->id,
                'assigned_to' => $staff->id,
                'title' => 'Excavation Work',
                'priority' => 'high',
                'status' => 'in_progress',
                'deadline' => now()->addDays(5)
            ]);
        }

        // 5. Add Vendors and Expenses
        $vendor = Vendor::create([
            'name' => 'Industrial Materials Co.',
            'category' => 'Materials',
            'email' => 'sales@industrialmaterials.com'
        ]);

        if ($projects->first()) {
            Expense::create([
                'portfolio_id' => $projects->first()->id,
                'vendor_id' => $vendor->id,
                'amount' => 5000.00,
                'category' => 'materials',
                'status' => 'pending',
                'due_date' => now()->addMonth()
            ]);
        }
    }
}
