<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staff = [
            [
                'name' => 'Arthur Beam, PE',
                'role' => 'Principal Structural Director & Founder',
                'bio' => 'Over 22 years of structural engineering and EPC project leadership across major high-rise and commercial infrastructure developments.',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974',
                'is_leadership' => true,
                'is_active' => true,
                'is_public_visible' => true,
                'order' => 1,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                ],
            ],
            [
                'name' => 'Sarah Brick, AIA',
                'role' => 'Chief Architect & BIM Systems Director',
                'bio' => 'Specializes in sustainable architectural systems, 4D building information modeling, and high-performance structural envelopes.',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976',
                'is_leadership' => true,
                'is_active' => true,
                'is_public_visible' => true,
                'order' => 2,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                ],
            ],
            [
                'name' => 'Marcus Steel, CSHM',
                'role' => 'Head of Field Operations & Jobsite Safety',
                'bio' => 'Oversees multi-trade site execution, OSHA-standard safety gates, heavy crane logistics, and critical-path milestone delivery.',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070',
                'is_leadership' => true,
                'is_active' => true,
                'is_public_visible' => true,
                'order' => 3,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                ],
            ],
            [
                'name' => 'Elena Vance, CFA',
                'role' => 'Director of Construction Capital & EVM',
                'bio' => 'Expert in capital expenditure tracking, procurement risk assessment, and transparent Earned Value lifecycle management.',
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961',
                'is_leadership' => true,
                'is_active' => true,
                'is_public_visible' => true,
                'order' => 4,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                ],
            ],
            [
                'name' => 'David Vance, PE',
                'role' => 'Structural Telemetry Director',
                'bio' => 'Directs digital jobsite telemetry, deploying sub-millimeter robotic total stations, drone photogrammetry, and live concrete curing sensors.',
                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=1974',
                'is_leadership' => true,
                'is_active' => true,
                'is_public_visible' => true,
                'order' => 5,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                ],
            ],
            [
                'name' => 'Maya Lin, LEED AP',
                'role' => 'Senior BIM Computational Engineer',
                'bio' => 'Specializes in automating federated MEP clash reconciliation, embodied carbon calculations, and fabrication-ready shop model validation.',
                'photo' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=1974',
                'is_leadership' => true,
                'is_active' => true,
                'is_public_visible' => true,
                'order' => 6,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                ],
            ],
        ];

        foreach ($staff as $person) {
            $slug = Str::slug($person['name']);
            Staff::updateOrCreate(['slug' => $slug], $person);
        }
    }
}
