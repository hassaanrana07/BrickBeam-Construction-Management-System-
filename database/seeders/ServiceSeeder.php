<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Custom Building',
                'slug' => 'custom-building',
                'short_description' => 'Architectural excellence meets master craftsmanship in bespoke residential and commercial developments.',
                'description' => 'We specialize in ground-up luxury residential and bespoke commercial construction, translating ambitious architectural blueprints into high-precision structural reality. From deep geotechnical foundation anchoring to post-tensioned slabs and high-performance envelope enclosures, our dedicated project squads orchestrate every trade with zero tolerance for deviations.',
                'is_featured' => true,
                'status' => 'published',
                'structural_type' => 'Private Residential & Bespoke Estates',
                'capability_tools' => ['AutoCAD 2026', 'Autodesk Revit BIM', 'Procore Field Telemetry', 'Trimble Robotic Total Stations'],
                'capability_features' => ['High-Performance Thermal Envelopes', 'Seismic Resilience & Deep Foundation Anchoring', 'Acoustic Structural Isolation', 'Custom Architectural Joinery'],
                'capability_deliverables' => ['Complete CAD & BIM As-Builts', 'Rigorous Geotechnical Compliance Audits', 'Milestone-Based Quality Assurance Passports', 'Commissioning & Facility Handover Protocol'],
                'operations_description' => 'Comprehensive turnkey lifecycle orchestration: site reconnaissance, structural calculations, subcontractor synchronization, and real-time biometric progress monitoring.',
                'operations_timeline' => '24-48 weeks',
                'operations_team' => 'Design & Engineering Elite Unit',
                'featured_image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
            ],
            [
                'title' => 'Commercial Renovation',
                'slug' => 'commercial-renovation',
                'short_description' => 'Transforming legacy spaces into high-density, energy-efficient commercial environments.',
                'description' => 'From enterprise campus overhauls and industrial adaptive reuse to high-traffic retail fit-outs, we modernize commercial real estate assets to maximize occupant density, technological agility, and sustainability ratings. Our phased construction protocols ensure minimal downtime while executing complex structural modifications.',
                'is_featured' => true,
                'status' => 'published',
                'structural_type' => 'Corporate Infrastructure & Adaptive Reuse',
                'capability_tools' => ['Matterport 3D Scanning', 'Primavera P6 Gantt Engine', 'Carbon Fiber Composite Retrofitting', 'Navisworks Clash Detection'],
                'capability_features' => ['LEED / WELL Green Building Upgrades', 'Carbon Fiber Structural Retrofit', 'Smart Building IoT & Automation', 'Acoustic Glass Curtain Walls'],
                'capability_deliverables' => ['Phased Disruption Mitigation Plan', 'Structural Load Recalibration Audit', 'Energy Efficacy Benchmark Certificate', 'Turnkey Facility Transfer Documentation'],
                'operations_description' => 'Strategic command of structural logistics, night-shift staging, tenant occupancy safety partitioning, and rapid-turnaround commissioning.',
                'operations_timeline' => '12-24 weeks',
                'operations_team' => 'Commercial Infrastructure Taskforce',
                'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
            ],
            [
                'title' => 'Quality Renovation',
                'slug' => 'quality-renovation',
                'short_description' => 'Precision structural overhauls, historical restoration, and optimization of architectural environments.',
                'description' => 'Our quality renovation methodology merges heritage architectural preservation with state-of-the-art seismic, structural, and building science enhancements. By deploying high-density lidar scanning and non-destructive testing, we diagnose underlying structural vulnerabilities before executing museum-grade restoration.',
                'is_featured' => true,
                'status' => 'published',
                'structural_type' => 'Technical Overhaul & Historic Assets',
                'capability_tools' => ['LiDAR Spatial Scanning', 'Non-Destructive Concrete Testing (NDT)', 'Micro-Crack Ultrasonic Analysis', 'Historic Mortar Matching'],
                'capability_features' => ['Historical Masonry Restoration', 'Subterranean Waterproofing Membranes', 'Load-Bearing Wall Optimization', 'Precision Timber Glulam Reinforcement'],
                'capability_deliverables' => ['Heritage Preservation Compliance Dossier', 'Structural Defect Mitigation Index', 'Material Lifespan Warranty Certificates', 'Final Thermal Imaging Heatmap'],
                'operations_description' => 'Sub-millimeter laser scanning, historical asset cataloging, delicate facade stabilization, and high-efficiency MEP integration.',
                'operations_timeline' => '8-16 weeks',
                'operations_team' => 'Heritage & Structural Restoration Specialists',
                'featured_image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
            ],
            [
                'title' => 'Structural Design',
                'slug' => 'structural-design',
                'short_description' => 'Strategic engineering matrices, finite element analysis, and heavy infrastructure feasibility.',
                'description' => 'Engineering precision at scale for multi-story residential towers, industrial logistics centers, and public infrastructure. Our structural engineers formulate optimized load paths, dynamic seismic response models, and aerodynamic envelope solutions using advanced finite element analysis (FEA) and 4D BIM simulations.',
                'is_featured' => true,
                'status' => 'published',
                'structural_type' => 'Engineering Matrix & High-Rise Infrastructure',
                'capability_tools' => ['SAP2000 Structural FEA', 'ETABS Building Modeling', 'Autodesk Civil 3D', 'Rhino Grasshopper Parametric Engine'],
                'capability_features' => ['Wind Tunnel Dynamic Load Modeling', 'Nonlinear Seismic Response Analysis', 'Tuned Mass Damper Optimization', 'Precast & Post-Tensioned Systems'],
                'capability_deliverables' => ['Stamped Engineering Calculations', 'Constructability & Value-Engineering Dossier', 'Comprehensive Steel & Rebar Schedules', 'Digital Twin BIM Data Repository'],
                'operations_description' => 'Parametric structural modeling, peer-reviewed engineering stamps, continuous site inspection, and automated strain telemetry.',
                'operations_timeline' => '4-12 weeks',
                'operations_team' => 'Principal Structural Engineering Directorate',
                'featured_image' => 'https://images.unsplash.com/photo-1504917595217-d4dc5f566fab?q=80&w=2070',
            ],
        ];

        foreach ($services as $service) {
            $existing = Service::withTrashed()->where('slug', $service['slug'])->first();
            if ($existing) {
                if ($existing->trashed()) $existing->restore();
                $existing->update($service);
            } else {
                Service::create($service);
            }
        }
    }
}
