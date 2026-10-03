<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        Lead::query()->delete();

        $leads = [
            [
                'name' => 'Alexander Sterling',
                'email' => 'alexander.sterling@sterling-realty.com',
                'phone' => '+92 (51) 892-4100',
                'company' => 'Sterling Capital REIT',
                'source' => 'Direct RFP',
                'message' => 'Requesting technical proposal and Earned Value schedule for a 24-story commercial tower in Islamabad Blue Area.',
                'lead_score' => 95,
                'status' => 'qualified',
                'internal_notes' => 'Executive team met on Oct 1. High intent. Ready for BIM Level 2 integration.',
                'ip_address' => '115.186.141.22',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/126.0.0.0',
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Sophia Chen',
                'email' => 'sophia.chen@chen-development.com',
                'phone' => '+92 (42) 357-8901',
                'company' => 'Chen Luxury Living Group',
                'source' => 'Public Portfolio',
                'message' => 'Interested in custom multi-unit residential development with seismic retrofitting and 4D digital twin monitoring.',
                'lead_score' => 88,
                'status' => 'new',
                'internal_notes' => 'Inquiry originating from custom building module showcase.',
                'ip_address' => '39.40.18.90',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'created_at' => now()->subDays(4),
            ],
            [
                'name' => 'Tariq Al-Mansoor',
                'email' => 't.mansoor@gulf-infra.ae',
                'phone' => '+971 4 390 5500',
                'company' => 'Vanguard Infrastructure Group',
                'source' => 'Engineering Referral',
                'message' => 'Evaluating general contracting and project controls platforms for a 350,000 sq ft logistics fulfillment center.',
                'lead_score' => 92,
                'status' => 'proposal',
                'internal_notes' => 'Contract draft submitted. Waiting on final board review.',
                'ip_address' => '94.200.12.44',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Edge/126.0.0.0',
                'created_at' => now()->subDays(7),
            ],
            [
                'name' => 'Marcus Thorne',
                'email' => 'm.thorne@thornelogistics.com',
                'phone' => '+1 (212) 555-0194',
                'company' => 'Thorne Global Logistics',
                'source' => 'Web Intelligence',
                'message' => 'Need automated cost baseline tracking and biometric site gate integrations for cold storage facility.',
                'lead_score' => 78,
                'status' => 'contacted',
                'internal_notes' => 'Initial discovery call scheduled with lead engineer.',
                'ip_address' => '172.56.21.8',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/125.0.0.0',
                'created_at' => now()->subDays(12),
            ],
            [
                'name' => 'Elena Rostova',
                'email' => 'elena@rostova-arch.ch',
                'phone' => '+41 22 730 4000',
                'company' => 'Rostova Architectural Studio',
                'source' => 'Public Portfolio',
                'message' => 'Inquiring regarding parametric structural design verification and subcontractor ticketing workflows.',
                'lead_score' => 85,
                'status' => 'qualified',
                'internal_notes' => 'Interested in architectural collaboration SLA.',
                'ip_address' => '194.230.14.77',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_4) Safari/605.1.15',
                'created_at' => now()->subDays(15),
            ],
            [
                'name' => 'Engr. Bilal Hashmi',
                'email' => 'bilal.hashmi@apex-builders.pk',
                'phone' => '+92 (21) 345-2100',
                'company' => 'Apex Commercial Real Estate',
                'source' => 'Direct RFP',
                'message' => 'Commercial renovation scope for 18-floor corporate headquarters in Clifton, Karachi.',
                'lead_score' => 96,
                'status' => 'won',
                'internal_notes' => 'Deployment signed off. Transferred to active project matrix.',
                'ip_address' => '182.185.120.3',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/126.0.0.0',
                'created_at' => now()->subDays(25),
            ],
            [
                'name' => 'Hassan Raza',
                'email' => 'hassan@skyline-properties.pk',
                'phone' => '+92 (51) 280-9911',
                'company' => 'Skyline Urban Developers',
                'source' => 'Newsletter Dispatch',
                'message' => 'Seeking full turnkey PMO management for residential housing enclave phase 2.',
                'lead_score' => 64,
                'status' => 'contacted',
                'internal_notes' => 'Sent introductory portfolio brochure and rate schedule.',
                'ip_address' => '39.50.211.55',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/124.0.0.0',
                'created_at' => now()->subDays(30),
            ],
            [
                'name' => 'Dr. Zaid Malik',
                'email' => 'zmalik@medtech-facilities.com',
                'phone' => '+92 (42) 366-7788',
                'company' => 'MedTech Healthcare Infrastructure',
                'source' => 'Direct RFP',
                'message' => 'Specialized MEP cleanroom and hospital surgical wing expansion compliance verification.',
                'lead_score' => 90,
                'status' => 'proposal',
                'internal_notes' => 'HVAC & cleanroom specs reviewed by senior MEP engineer.',
                'ip_address' => '115.186.88.19',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/126.0.0.0',
                'created_at' => now()->subDays(38),
            ],
        ];

        foreach ($leads as $lead) {
            Lead::create($lead);
        }
    }
}
