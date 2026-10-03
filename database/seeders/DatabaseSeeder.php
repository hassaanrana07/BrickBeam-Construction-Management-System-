<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\GlobalSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles and Permissions
        $this->call(RolePermissionSeeder::class);

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

        if ($seedPassword) {
            // Super Admin
            $superAdmin = User::updateOrCreate(
                ['email' => 'admin@brickbeam.com'],
                [
                    'name' => 'Super Admin',
                    'password' => Hash::make($seedPassword),
                ]
            );
            $superAdmin->assignRole('Super Admin');

            // Admin Manager
            $adminManager = User::updateOrCreate(
                ['email' => 'manager@brickbeam.com'],
                [
                    'name' => 'Admin Manager',
                    'password' => Hash::make($seedPassword),
                ]
            );
            $adminManager->assignRole('Manager');

            // Editor
            $editor = User::updateOrCreate(
                ['email' => 'editor@brickbeam.com'],
                [
                    'name' => 'Editor',
                    'password' => Hash::make($seedPassword),
                ]
            );
            $editor->assignRole('Staff');

            // Support
            $support = User::updateOrCreate(
                ['email' => 'support@brickbeam.com'],
                [
                    'name' => 'Support',
                    'password' => Hash::make($seedPassword),
                ]
            );
            $support->assignRole('Staff');

            // Financial Support
            $financialSupport = User::updateOrCreate(
                ['email' => 'finance@brickbeam.com'],
                [
                    'name' => 'Financial Support',
                    'password' => Hash::make($seedPassword),
                ]
            );
            $financialSupport->assignRole('Finance Support');
        }

        // Seed Global Settings
        $this->call(GlobalSettingSeeder::class);

        $this->call([
            PageSeeder::class,
            ServiceSeeder::class,
            PortfolioSeeder::class,
            BlogSeeder::class,
            TestimonialSeeder::class,
            LocationSeeder::class,
            CostEstimatorSeeder::class,
            StaffSeeder::class,
            LeadSeeder::class,
            TaskSeeder::class,
            ExpenseSeeder::class,
        ]);
    }
}
