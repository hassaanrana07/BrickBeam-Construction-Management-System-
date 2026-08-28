<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Lead;
use App\Models\User;
use App\Models\Testimonial;
use App\Models\Location;
use App\Models\Staff;
use App\Models\FAQ;
use App\Models\Certification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        // 1. Leadership Staff
        $staff = [
            [
                'name' => 'Engr. Arthur Beam',
                'role' => 'Principal Structural Engineer & Founder',
                'is_leadership' => true,
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974',
                'bio' => 'Over 22 years of structural engineering and EPC project leadership across major high-rise and commercial infrastructure developments.'
            ],
            [
                'name' => 'Sarah Brick',
                'role' => 'Chief Architect & Design Director',
                'is_leadership' => true,
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976',
                'bio' => 'Specializes in sustainable architectural systems, building information modeling (BIM), and high-performance structural envelopes.'
            ],
            [
                'name' => 'Marcus Steel',
                'role' => 'Head of Project Operations & Safety',
                'is_leadership' => true,
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070',
                'bio' => 'Oversees site execution, OSHA-standard safety protocols, heavy equipment logistics, and critical-path milestone delivery.'
            ],
            [
                'name' => 'Elena Vance',
                'role' => 'Director of Construction Finance & Estimating',
                'is_leadership' => true,
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961',
                'bio' => 'Expert in capital expenditure tracking, procurement risk assessment, and transparent financial lifecycle management.'
            ],
        ];

        foreach ($staff as $idx => $s) {
            Staff::updateOrCreate(['slug' => Str::slug($s['name'])], [
                'name' => $s['name'],
                'role' => $s['role'],
                'is_leadership' => $s['is_leadership'],
                'is_active' => true,
                'is_public_visible' => true,
                'photo' => $s['photo'],
                'bio' => $s['bio'],
                'order' => $idx
            ]);
        }

        // 2. Services (The 6 Core Modules required by prompt + Specialized ones)
        $services = [
            [
                'title' => 'Project Management',
                'slug' => 'project-management',
                'short_description' => 'Plan and control construction projects from a centralized, real-time workspace with predictive milestone tracking.',
                'description' => 'BrickBeam Project Management is an end-to-end operational suite engineered for construction general contractors, real estate developers, and civil engineering teams. From pre-construction feasibility and blueprint approvals to field execution and final client handover, we bring clarity, transparency, and strict timeline adherence to every build.',
                'structural_type' => 'EPC Management & Site Governance',
                'capability_tools' => ['Procore Sync', 'Primavera P6', 'BIM 360', 'AutoCAD Civil', 'DroneDeploy'],
                'capability_features' => [
                    'Critical Path Method (CPM) timeline modeling',
                    'Real-time site progress and milestone verification',
                    'Centralized blueprint and revision repository',
                    'Subcontractor coordination and permit tracking',
                    'Automated field reporting and daily log synchronization'
                ],
                'capability_deliverables' => [
                    'Comprehensive Project Execution Plan (PEP)',
                    'Integrated 4D BIM Construction Schedule',
                    'Risk Mitigation & Contingency Protocols',
                    'Weekly Stakeholder Milestone Audits'
                ],
                'operations_description' => 'Multi-tiered operational control overseeing daily site logs, material intake validation, inspection sign-offs, and critical path adjustments.',
                'operations_timeline' => 'Continuous across Project Lifecycle',
                'operations_team' => 'Project Management Office (PMO) & Site Superintendent Unit',
                'operations_bullets' => [
                    'Daily digital logs and field superintendent syncs',
                    'Drone-based aerial site surveys and photogrammetry',
                    'Automated delay alerts and corrective action planning'
                ],
                'phases_details' => [
                    ['title' => 'Feasibility & Pre-Construction Scoping', 'description' => 'Site surveying, geotechnical review, budget benchmarks, and baseline schedule formation.'],
                    ['title' => 'Procurement & Permitting', 'description' => 'Contractor onboarding, regulatory compliance filings, and long-lead material procurement.'],
                    ['title' => 'Site Execution & Coordination', 'description' => 'Ground breaking, structural erection, MEP integration, and daily progress auditing.'],
                    ['title' => 'Commissioning & Handover', 'description' => 'Punch list resolution, quality assurance certifications, and asset commissioning.']
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 1
            ],
            [
                'title' => 'Task Management',
                'slug' => 'task-management',
                'short_description' => 'Assign responsibilities, monitor deadlines, prevent bottlenecks, and keep field and office teams completely aligned.',
                'description' => 'Construction execution lives or dies on daily task accountability. BrickBeam Task Management replaces chaotic spreadsheets and WhatsApp threads with structured, geo-tagged task tickets tied directly to project drawings and milestone deliverables. Subcontractors and site engineers know exactly what to build, inspect, and approve every morning.',
                'structural_type' => 'Field Execution & Task Tracking',
                'capability_tools' => ['Geo-Tagged Mobile App', 'Kanban Field Boards', 'Gantt Workflows', 'Punch List Engine'],
                'capability_features' => [
                    'Visual Kanban & Gantt task boards with priority tagging',
                    'Photo & video proof of work submission from mobile app',
                    'Automated push notifications for blocking issues and safety flags',
                    'Subcontractor SLA and turnaround measurement',
                    'Direct linking of tasks to BIM 3D model coordinates'
                ],
                'capability_deliverables' => [
                    'Daily Task Manifest & Punch Lists',
                    'Field Inspection Sign-Off Reports',
                    'Subcontractor Performance Scorecards',
                    'Corrective Action Tracking Logs'
                ],
                'operations_description' => 'Synchronized task assignment that ensures zero downtime between concrete pouring, curing windows, electrical conduit placement, and finishing crews.',
                'operations_timeline' => 'Daily / Shift-Based Execution',
                'operations_team' => 'Field Engineers & Subcontractor Foremen',
                'operations_bullets' => [
                    'Morning toolbox meetings aligned with daily digital boards',
                    'Instant defect tagging with photo attachments',
                    'Superintendent digital sign-off upon task completion'
                ],
                'phases_details' => [
                    ['title' => 'Work Breakdown Structure', 'description' => 'Hierarchical breakdown of master construction milestones into granular field tasks.'],
                    ['title' => 'Assignment & Crew Allocation', 'description' => 'Allocating trades and labor crews with clear specifications and materials checklists.'],
                    ['title' => 'Field Execution & Verification', 'description' => 'Real-time progress logging, inspection checkpoints, and photo documentation.'],
                    ['title' => 'Quality Sign-Off & Archiving', 'description' => 'Superintendent approval, punch list sign-off, and automated task closure.']
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 2
            ],
            [
                'title' => 'Team Management',
                'slug' => 'team-management',
                'short_description' => 'Manage project teams, subcontractor trades, labor allocation, safety certifications, and role permissions efficiently.',
                'description' => 'Orchestrating hundreds of engineers, steel fixers, carpenters, and MEP specialists requires uncompromising visibility. BrickBeam Team Management enables centralized workforce scheduling, safety compliance auditing, credential verification, and granular role-based permissions across desktop and mobile devices.',
                'structural_type' => 'Workforce Logistics & Safety Governance',
                'capability_tools' => ['Biometric Site Attendance', 'Safety Credential Vault', 'Role-Based Access Control', 'Crew Dispatch Planner'],
                'capability_features' => [
                    'Role-based access matrix for Owners, Contractors, and Subs',
                    'Real-time on-site headcount and labor allocation metrics',
                    'Digital safety induction and OSHA certification tracking',
                    'Automated timesheets with geofencing validation',
                    'Skill matrix mapping and crew productivity benchmarks'
                ],
                'capability_deliverables' => [
                    'Site Workforce Attendance & Labor Utilization Audits',
                    'Subcontractor Compliance & Safety Passports',
                    'Resource Leveling & Crew Allocation Schedules',
                    'Overtime and Labor Cost Reconciliation Reports'
                ],
                'operations_description' => 'Continuous workforce coordination ensuring optimal labor ratios, safety adherence, and zero unauthorized site entry.',
                'operations_timeline' => 'Ongoing Workforce Management',
                'operations_team' => 'Human Capital, Safety Officers & Site Supervisors',
                'operations_bullets' => [
                    'Biometric / QR-code site gate check-in and induction checking',
                    'Daily safety toolbox talks logged in digital repository',
                    'Subcontractor roster leveling to avoid site crowding'
                ],
                'phases_details' => [
                    ['title' => 'Onboarding & Credential Verification', 'description' => 'Verification of trade licenses, OSHA certifications, and insurance coverage.'],
                    ['title' => 'Crew Structuring & Shift Scheduling', 'description' => 'Structuring multi-trade shifts aligned with crane access and concrete schedules.'],
                    ['title' => 'Daily Attendance & Health/Safety Checks', 'description' => 'Automated check-ins, PPE compliance audits, and temperature/safety checks.'],
                    ['title' => 'Performance & Labor Auditing', 'description' => 'Review of trade efficiency, man-hours spent, and safety track records.']
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 3
            ],
            [
                'title' => 'Budget & Finance',
                'slug' => 'budget-management',
                'short_description' => 'Track budgets, purchase orders, expenses, cashflow forecasting, and financial performance with zero cost surprises.',
                'description' => 'Cost overruns are the number one threat in construction. BrickBeam Budget & Finance delivers institutional-grade financial oversight, from Bill of Quantities (BOQ) creation and subcontractor payment certificates to material purchase orders, variance tracking, and real-time cashflow forecasting.',
                'structural_type' => 'Construction Financial Engineering & Cost Control',
                'capability_tools' => ['Earned Value Management (EVM)', 'Automated BOQ Calculator', 'Invoice OCR Matching', 'Cost Variance Predictor'],
                'capability_features' => [
                    'Live Earned Value Management (EVM) tracking (CPI & SPI)',
                    'Multi-tier approval workflows for purchase orders and variations',
                    'Progress billing linked directly to verified milestone completions',
                    'Material price fluctuation and contingency reserves monitoring',
                    'Export-ready financial statements and audit trails'
                ],
                'capability_deliverables' => [
                    'Comprehensive Cost Breakdown Structure (CBS)',
                    'Monthly Interim Payment Certificates (IPC)',
                    'Cost Variance Analysis & Forecast-at-Completion (EAC)',
                    'Subcontractor Payment & Retention Statements'
                ],
                'operations_description' => 'Precision financial auditing that reconciles actual site delivery with purchase orders, invoices, and bank draws in real time.',
                'operations_timeline' => 'Real-Time Financial Sync',
                'operations_team' => 'Quantity Surveyors & Financial Controllers',
                'operations_bullets' => [
                    'Automated 3-way matching between PO, delivery note, and invoice',
                    'Real-time notification on budget threshold breaches (>85%)',
                    'Subcontractor retention management and release schedules'
                ],
                'phases_details' => [
                    ['title' => 'Baseline Budget Modeling', 'description' => 'Detailed BOQ derivation, material unit pricing, and contingency allocations.'],
                    ['title' => 'Procurement & Commitment Tracking', 'description' => 'Issuing POs, binding contracts, and locking in supplier trade rates.'],
                    ['title' => 'Live Expenditure & Variance Auditing', 'description' => 'Tracking real-time burn rate against milestone completion percentages.'],
                    ['title' => 'Final Account & Audit Reconciliation', 'description' => 'Settlement of variation orders, retention release, and final fiscal closure.']
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1454165833767-027ffea7025c?q=80&w=2070',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 4
            ],
            [
                'title' => 'Progress Tracking',
                'slug' => 'progress-tracking',
                'short_description' => 'Monitor real-time project completion, physical percent done, and identify delays before they become expensive problems.',
                'description' => 'Know the true status of your job site at any moment. BrickBeam Progress Tracking marries drone orthomosaic imagery, 3D laser scans, site sensor telemetry, and engineer sign-offs into a unified progress dashboard that highlights planned vs. actual progress with laser precision.',
                'structural_type' => 'Photogrammetry & Schedule Telemetry',
                'capability_tools' => ['Drone Photogrammetry', '360° Site Cameras', 'S-Curve Schedule Modeler', 'LiDAR Point Clouds'],
                'capability_features' => [
                    'Automated S-Curve tracking (Planned vs. Actual vs. Forecast)',
                    'Side-by-side photo comparison of planned 3D BIM vs actual site state',
                    'Delay root-cause identification and weather delay logging',
                    'Substructure, Superstructure, and MEP stage-gate progress metrics',
                    'Client-accessible public or private progress portal'
                ],
                'capability_deliverables' => [
                    'Weekly Visual Progress Dossier with 360° Imagery',
                    'Earned Schedule (ES) & Milestone Projection Reports',
                    'Time-Impact Analysis (TIA) for Schedule Deviations',
                    'Executive Milestone Completion Certificates'
                ],
                'operations_description' => 'Weekly high-resolution drone passes and 360-degree site walkthroughs converted into verified progress percentages.',
                'operations_timeline' => 'Weekly / Bi-Weekly Cadence',
                'operations_team' => 'Survey Engineers & Quality Assurance Unit',
                'operations_bullets' => [
                    'High-resolution drone ortho-mapping every Tuesday and Friday',
                    'AI-powered object counting for rebar, structural columns, and drywalls',
                    'Instant schedule adjustment recommendations upon detected variance'
                ],
                'phases_details' => [
                    ['title' => 'Baseline Schedule Ingestion', 'description' => 'Importing CPM schedule and linking tasks to 3D architectural models.'],
                    ['title' => 'Periodic Reality Capture', 'description' => 'Capturing drone photos, 360 virtual tours, and site superintendent logs.'],
                    ['title' => 'AI Variance & Delta Analysis', 'description' => 'Comparing physical reality against CAD/BIM models to compute true progress.'],
                    ['title' => 'Stakeholder Reporting & Actioning', 'description' => 'Publishing visual progress dashboards to owners and executive leaders.']
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1517089535819-3d4400263f16?q=80&w=2070',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 5
            ],
            [
                'title' => 'Reports & Analytics',
                'slug' => 'reports-analytics',
                'short_description' => 'Turn complex project data into automated executive reports, audit-ready compliance records, and predictive business insights.',
                'description' => 'Make data-driven construction decisions with automated reporting. BrickBeam Reports & Analytics aggregates millions of field data points into crisp executive dashboards, safety compliance audits, vendor reliability rankings, and machine-learning risk predictions for enterprise portfolio owners.',
                'structural_type' => 'Predictive Construction Intelligence & Reporting',
                'capability_tools' => ['PowerBI Sync', 'Automated PDF Engine', 'Custom Metric Builder', 'Predictive ML Engine'],
                'capability_features' => [
                    'One-click automated stakeholder PDF report generation',
                    'Custom KPI dashboards for Executives, Project Managers, and Engineers',
                    'Safety Incident Frequency Rate (LTIFR) compliance reports',
                    'Material consumption vs waste analytics',
                    'Subcontractor scorecards across quality, budget, and timeliness'
                ],
                'capability_deliverables' => [
                    'Executive Monthly Portfolio Performance Pack',
                    'Regulatory & Environmental Compliance Audit Reports',
                    'Subcontractor Quality & Safety Ranking Dossier',
                    'Predictive Cost & Schedule Risk Assessment Matrix'
                ],
                'operations_description' => 'Automated data aggregation pipelines synthesizing field inspections, financial ledgers, and sensor telemetry into actionable reports.',
                'operations_timeline' => 'Daily, Weekly & Monthly Cycles',
                'operations_team' => 'Data Analytics Unit & Executive PMO',
                'operations_bullets' => [
                    'Automated Monday morning executive briefings sent to leadership',
                    'Instant PDF exports formatted for banking and investor reviews',
                    'Historical project benchmarking to optimize future bidding'
                ],
                'phases_details' => [
                    ['title' => 'Data Standardization & Aggregation', 'description' => 'Unifying site logs, equipment sensors, timesheets, and accounting ledgers.'],
                    ['title' => 'Automated Anomaly Detection', 'description' => 'Running statistical algorithms to spot cost surges, safety patterns, and bottlenecks.'],
                    ['title' => 'Executive Dashboard Rendering', 'description' => 'Rendering interactive visual charts, S-curves, and drill-down KPI widgets.'],
                    ['title' => 'Automated Distribution & Archival', 'description' => 'Delivering scheduled compliance reports to investors, banks, and regulators.']
                ],
                'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 6
            ],
            // Additional specialized capabilities
            [
                'title' => 'Structural Design & Engineering',
                'slug' => 'structural-design',
                'short_description' => 'Seismic-resistant structural engineering, post-tensioned foundation design, and advanced load-bearing calculations.',
                'description' => 'Our specialized structural engineering wing develops blueprints and load-bearing matrices for high-rises, commercial malls, and bridge infrastructure.',
                'structural_type' => 'Advanced Structural Engineering',
                'capability_tools' => ['ETABS', 'SAP2000', 'Revit Structure', 'AutoCAD Civil 3D'],
                'capability_features' => ['Seismic Zone 4 Dampening', 'Post-Tensioned Slabs', 'Wind Tunnel Simulation'],
                'capability_deliverables' => ['Structural Calculations', 'Vetted Blueprint Pack', 'Municipal Approval Dossier'],
                'operations_description' => 'Full structural engineering design and PE stamp certification.',
                'operations_timeline' => '4-12 Weeks',
                'operations_team' => 'Principal Structural Engineering Squad',
                'featured_image' => 'https://images.unsplash.com/photo-1504917595217-d4dc5f566fab?q=80&w=2070',
                'is_featured' => false,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 7
            ]
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['slug' => $srv['slug']], $srv);
        }

        // 3. Featured Projects (Skyline Residence, Urban Business Center, Riverside Villas, Metro Office Complex, etc.)
        $projects = [
            [
                'title' => 'Skyline Residence',
                'slug' => 'skyline-residence',
                'project_type' => 'Residential Construction',
                'location' => 'Sector F-7, Islamabad',
                'client_name' => 'Al-Meezan Luxury Developments',
                'budget_range' => 'PKR 85M',
                'total_budget' => 85000000,
                'execution_status' => 'In Progress',
                'start_date' => now()->subMonths(14),
                'completion_date' => now()->addMonths(3),
                'short_description' => 'A premier 6-story ultra-luxury residential development featuring cantilevered balconies, smart home automation, and energy-neutral HVAC systems.',
                'description' => 'Skyline Residence represents the pinnacle of contemporary urban living, blending reinforced concrete architectural brutalism with warm timber louvers and floor-to-ceiling double-glazed thermal windows. Managed from foundation excavation through BrickBeam, the project achieved zero lost-time incidents and maintained a 98.4% schedule compliance index across all structural milestones.',
                'featured_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=2053',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070'
                ],
                'case_study_category' => 'Luxury Residential Development',
                'case_study_scope' => 'Turnkey EPC & Interior Fit-Out',
                'case_study_sector' => 'Residential',
                'cs_phase_1' => 'Subsurface Soil Nailing & Deep Raft Foundation (100%)',
                'cs_phase_2' => '6-Story Post-Tensioned Reinforced Concrete Frame (100%)',
                'cs_phase_3' => 'Smart MEP, VRF HVAC, and Acoustic Insulation (95%)',
                'cs_phase_4' => 'Imported Italian Marble & Architectural Facade Louvers (88%)',
                'cs_phase_5' => 'Smart Home Commissioning & Landscaping (Pending)',
                'cs_duration_weeks' => '68',
                'cs_team' => 'Residential Vanguard Taskforce',
                'cs_total_value' => 'PKR 85,000,000',
                'base_structure' => 'Post-Tensioned Reinforced Concrete with Shear Walls',
                'foundation_type' => 'Deep Raft Foundation on Micro-Piles',
                'total_floors' => 6,
                'floor_composition' => 'Post-Tensioned Flat Slabs',
                'structural_features' => [
                    'Seismic Zone 2B compliant structural ductile detailing',
                    'High-performance cantilevered steel and composite balconies',
                    'Thermal break double-glazed aluminum curtain walls',
                    'Rooftop infinity pool structural water-retaining basin'
                ],
                'capabilities' => [
                    'Real-time contractor task tracking via BrickBeam mobile app',
                    'Automated material testing batch logs (Cylinder compressive tests)',
                    'Subcontractor safety verification with zero lost-time incidents'
                ],
                'functional_features' => [
                    'Rooftop solar PV generation offsetting 45% of building power',
                    'Central VRF cooling and radiant underfloor heating',
                    'Integrated building management system (BMS)'
                ],
                'tools_used' => ['Revit BIM', 'ETABS 2024', 'BrickBeam Mobile', 'Primavera P6'],
                'technology_used' => 'BIM Level 3, Drone Photogrammetry, Sensor-Enabled Concrete Curing',
                'framework_type' => 'Agile CPM & Lean Construction Matrix',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 1
            ],
            [
                'title' => 'Urban Business Center',
                'slug' => 'urban-business-center',
                'project_type' => 'Commercial Construction',
                'location' => 'Clifton Block 4, Karachi',
                'client_name' => 'Habib Commercial Holdings',
                'budget_range' => 'PKR 140M',
                'total_budget' => 140000000,
                'execution_status' => 'In Progress',
                'start_date' => now()->subMonths(18),
                'completion_date' => now()->addMonths(6),
                'short_description' => 'A state-of-the-art 12-story commercial office tower engineered for financial institutions, tech headquarters, and premium retail.',
                'description' => 'Designed to meet international LEED Gold standards, the Urban Business Center combines high-strength steel-reinforced core construction with panoramic curtain glass facades. BrickBeam enabled rapid procurement coordination, sub-trade leveling, and live financial cost variance control across 35 independent trade contractors.',
                'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069',
                    'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070',
                    'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071'
                ],
                'case_study_category' => 'Commercial High-Rise Development',
                'case_study_scope' => 'Full EPC, Facade Engineering & Core MEP',
                'case_study_sector' => 'Commercial',
                'cs_phase_1' => 'Diaphragm Secant Wall & 3-Level Basement Excavation (100%)',
                'cs_phase_2' => 'Central Slipformed Core & Steel Composite Decking (100%)',
                'cs_phase_3' => 'High-Performance Unitized Glass Facade Erection (82%)',
                'cs_phase_4' => 'Chiller Plant, High-Speed Elevators & MEP Backbone (65%)',
                'cs_phase_5' => 'Interior Lobby Atrium & Tenant Fit-Out Enablement (Pending)',
                'cs_duration_weeks' => '96',
                'cs_team' => 'Commercial Core Engineering Unit',
                'cs_total_value' => 'PKR 140,000,000',
                'base_structure' => 'Dual System: Concrete Core Wall with Steel-Composite Perimeter Columns',
                'foundation_type' => 'Piled Raft with 1.2m Diameter Bored Piles',
                'total_floors' => 12,
                'floor_composition' => 'Composite Steel Decking with Cast-in-Place Concrete Slab',
                'structural_features' => [
                    'Wind tunnel tested aerodynamically optimized rounded corners',
                    'Triple-redundant fire suppression and smoke evacuation core',
                    'High-capacity freight logistics bay with subterranean loading docks'
                ],
                'capabilities' => [
                    '4D BIM schedule simulation to resolve crane conflict paths',
                    'Real-time budget tracking preventing cost overruns across steel procurement',
                    'Drone-based thermal inspection of unitized curtain wall installation'
                ],
                'functional_features' => [
                    'LEED Gold targeted energy efficiency and daylight harvesting',
                    'Destination-dispatch elevator system reducing wait times by 40%',
                    'Dedicated dual-source fiber internet and backup generators'
                ],
                'tools_used' => ['Navisworks Manage', 'ETABS', 'BrickBeam Finance', 'Procore'],
                'technology_used' => 'Unitized Glass Facades, Slipform Core Technology, IoT Concrete Sensors',
                'framework_type' => 'Integrated Project Delivery (IPD)',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 2
            ],
            [
                'title' => 'Riverside Villas',
                'slug' => 'riverside-villas',
                'project_type' => 'Residential Development',
                'location' => 'Bahria Phase 8, Rawalpindi',
                'client_name' => 'Greenfield Residential Consortium',
                'budget_range' => 'PKR 65M',
                'total_budget' => 65000000,
                'execution_status' => 'Completed',
                'start_date' => now()->subMonths(20),
                'completion_date' => now()->subMonths(1),
                'short_description' => 'A master-planned gated enclave of 18 luxury eco-villas featuring riverside views, private infinity pools, and sustainable water treatment infrastructure.',
                'description' => 'Riverside Villas was delivered 3 weeks ahead of schedule and 4.2% under budget utilizing BrickBeam Lean Task Management and daily progress auditing. Each villa features custom architectural stone cladding, solar microgrids, and earthquake-resilient frame structures.',
                'featured_image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=2053',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075'
                ],
                'case_study_category' => 'Master-Planned Community Development',
                'case_study_scope' => 'Complete Infrastructure & Villa Construction',
                'case_study_sector' => 'Residential',
                'cs_phase_1' => 'Road Infrastructure & Underground Utilities (100%)',
                'cs_phase_2' => '18 Individual Villa Foundation & Structural Erection (100%)',
                'cs_phase_3' => 'Roof Waterproofing, MEP & Solar Integration (100%)',
                'cs_phase_4' => 'Premium Finishes, Pools & Landscaping (100%)',
                'cs_phase_5' => 'Final Handover, Title Delivery & Client Walkthroughs (100%)',
                'cs_duration_weeks' => '78',
                'cs_team' => 'Greenfield Communities Squad',
                'cs_total_value' => 'PKR 65,000,000',
                'base_structure' => 'Reinforced Concrete Moment Frame with Clay Masonry',
                'foundation_type' => 'Combined Strip Footings with Water-Barrier Membranes',
                'total_floors' => 3,
                'floor_composition' => 'Two-Way Reinforced Solid Concrete Slabs',
                'structural_features' => [
                    'Waterfront retaining wall with geotextile drainage filter layers',
                    'Thermal insulated roof decking with reflective barrier coatings',
                    'Individual rainwater collection cisterns connected to landscape irrigation'
                ],
                'capabilities' => [
                    'Multi-villa parallel task dispatching via BrickBeam',
                    'Automated batch inspection logs for 18 parallel construction sites',
                    'Online client handover portal with warranty certificates'
                ],
                'functional_features' => [
                    'Grid-tied rooftop solar microgrid for each villa',
                    'Centralized greywater recycling facility',
                    'Smart community security access controls'
                ],
                'tools_used' => ['AutoCAD', 'BrickBeam Progress', 'Revit', 'Primavera'],
                'technology_used' => 'Precast Boundary Walls, Smart Water Management, Drone Mapping',
                'framework_type' => 'Lean Construction Scheduling',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 3
            ],
            [
                'title' => 'Metro Office Complex',
                'slug' => 'metro-office-complex',
                'project_type' => 'Commercial Development',
                'location' => 'Gulberg III, Lahore',
                'client_name' => 'Metropolitan Ventures Group',
                'budget_range' => 'PKR 220M',
                'total_budget' => 220000000,
                'execution_status' => 'In Progress',
                'start_date' => now()->subMonths(10),
                'completion_date' => now()->addMonths(14),
                'short_description' => 'A landmark 16-story twin-tower commercial development featuring high-performance curtain walls, integrated corporate atrium, and automated underground parking.',
                'description' => 'The Metro Office Complex sets a new benchmark for commercial architecture in Lahore. Spanning over 350,000 square feet of prime office space, the project leverages BrickBeam for automated Earned Value Analysis, sub-trade progress tracking, and precision equipment logistics.',
                'featured_image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070',
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069',
                    'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070'
                ],
                'case_study_category' => 'Twin-Tower Commercial Development',
                'case_study_scope' => 'Turnkey High-Rise EPC & Smart Automation',
                'case_study_sector' => 'Commercial',
                'cs_phase_1' => 'Deep Secant Piling & 4-Level Basements (100%)',
                'cs_phase_2' => 'Tower A & B Structural Core Framing (70%)',
                'cs_phase_3' => 'Connecting Sky-Bridge & Facade Sub-Frames (30%)',
                'cs_phase_4' => 'HVAC Chiller Plant & Vertical Transportation (Pending)',
                'cs_phase_5' => 'Smart Building Commissioning & Handover (Pending)',
                'cs_duration_weeks' => '110',
                'cs_team' => 'Metropolitan Engineering Unit',
                'cs_total_value' => 'PKR 220,000,000',
                'base_structure' => 'Twin Slipformed Concrete Cores with Outrigger Steel Trusses',
                'foundation_type' => 'Heavy Piled Raft with Continuous Soil Grouting',
                'total_floors' => 16,
                'floor_composition' => 'Post-Tensioned Flat Slabs with Drop Panels',
                'structural_features' => [
                    'Skybridge connecting Tower A & Tower B at 8th level',
                    'High-damping tuned liquid mass damper for wind comfort',
                    'Heavy-duty vehicle turntable and automated robotic parking'
                ],
                'capabilities' => [
                    'Real-time BIM 360 clash detection and issue resolution',
                    'Daily labor headcount and biometric site tracking via BrickBeam',
                    'Automated interim payment certification linked to verified progress'
                ],
                'functional_features' => [
                    'Central Building Management System (BMS) with energy metering',
                    'Double-glazed low-E acoustic curtain wall with motorized sunshades',
                    '100% emergency generator power backup and UPS systems'
                ],
                'tools_used' => ['ETABS', 'AutoCAD Civil', 'Revit BIM', 'BrickBeam Analytics'],
                'technology_used' => 'Slipform Core, Skybridge Structural Lifting, IoT Telemetry',
                'framework_type' => 'Integrated Project Delivery (IPD)',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 4
            ],
            [
                'title' => 'The Monolith Plaza',
                'slug' => 'the-monolith-plaza',
                'project_type' => 'Commercial High-Rise',
                'location' => 'Downtown Financial District',
                'client_name' => 'Vanguard Capital Real Estate',
                'budget_range' => 'PKR 350M',
                'total_budget' => 350000000,
                'execution_status' => 'In Progress',
                'start_date' => now()->subMonths(24),
                'completion_date' => now()->addMonths(4),
                'short_description' => 'A towering 28-story landmark glass-and-steel skyscraper engineered for global fintech corporations and luxury executive suites.',
                'description' => 'The Monolith Plaza is an engineering marvel designed with seismic damping dampers, high-speed destination elevators, and an expansive public cultural plaza at ground level.',
                'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069'
                ],
                'case_study_category' => 'Skyscraper Construction',
                'case_study_scope' => 'Full EPC & High-Rise Operations',
                'case_study_sector' => 'Commercial',
                'cs_phase_1' => 'Deep Foundation & Basement Erection (100%)',
                'cs_phase_2' => 'Core Wall & Steel Composite Erection (100%)',
                'cs_phase_3' => 'Full Curtain Wall Facade Cladding (95%)',
                'cs_phase_4' => 'Interior Fit-Out & MEP Backbone (80%)',
                'cs_phase_5' => 'Final Commissioning & Handover (Pending)',
                'cs_duration_weeks' => '130',
                'cs_team' => 'Skyscraper Taskforce Prime',
                'cs_total_value' => 'PKR 350,000,000',
                'base_structure' => 'Composite Steel & Concrete Core',
                'foundation_type' => 'Deep Friction Piles',
                'total_floors' => 28,
                'floor_composition' => 'Post-Tensioned Concrete',
                'tools_used' => ['ETABS', 'Revit', 'BrickBeam PMO'],
                'technology_used' => 'BIM 360, Slipform Core',
                'framework_type' => 'Agile CPM',
                'is_featured' => false,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 5
            ],
            [
                'title' => 'Alpha Industrial Hub',
                'slug' => 'alpha-industrial-hub',
                'project_type' => 'Industrial Complex',
                'location' => 'M-3 Industrial City, Faisalabad',
                'client_name' => 'National Logistics & Freight Corp',
                'budget_range' => 'PKR 180M',
                'total_budget' => 180000000,
                'execution_status' => 'In Progress',
                'start_date' => now()->subMonths(12),
                'completion_date' => now()->addMonths(8),
                'short_description' => 'A heavy-duty 400,000 sq ft smart distribution and logistics facility equipped with automated high-bay racking and solar power.',
                'description' => 'Alpha Industrial Hub features post-tensioned heavy-load floor slabs, wide-span pre-engineered steel frames, and temperature-controlled storage chambers built for 24/7 freight logistics.',
                'featured_image' => 'https://images.unsplash.com/photo-1590644365607-1c5a519a7a37?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1590644365607-1c5a519a7a37?q=80&w=2070',
                    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070'
                ],
                'case_study_category' => 'Industrial Logistics Facility',
                'case_study_scope' => 'Civil & PEB Steel Construction',
                'case_study_sector' => 'Industrial',
                'cs_phase_1' => 'Earthwork & Heavy Raft Foundation (100%)',
                'cs_phase_2' => 'Pre-Engineered Steel Framing & Cladding (100%)',
                'cs_phase_3' => 'Laser-Screed Heavy Concrete Flooring (75%)',
                'cs_phase_4' => 'Dock Levelers, MEP & Fire Safety Systems (40%)',
                'cs_phase_5' => 'Solar Microgrid & Handover (Pending)',
                'cs_duration_weeks' => '85',
                'cs_team' => 'Industrial Infrastructure Unit',
                'cs_total_value' => 'PKR 180,000,000',
                'base_structure' => 'Pre-Engineered Structural Steel Frame',
                'foundation_type' => 'Pad Footings with Grade Beams',
                'total_floors' => 2,
                'floor_composition' => 'Super-Flat Laser-Screed Concrete',
                'tools_used' => ['Tekla Structures', 'AutoCAD', 'BrickBeam Mobile'],
                'technology_used' => 'Laser Screeding, Pre-Engineered Steel',
                'framework_type' => 'Lean Construction',
                'is_featured' => false,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'order' => 6
            ]
        ];

        foreach ($projects as $proj) {
            Portfolio::updateOrCreate(['slug' => $proj['slug']], $proj);
        }

        // 4. Testimonials
        $testimonials = [
            [
                'client_name' => 'Tariq Al-Mansoor',
                'client_company' => 'Apex Real Estate Partners',
                'client_position' => 'Chief Executive Officer',
                'testimonial' => 'BrickBeam gave our executive board complete visibility over multiple commercial high-rises. Having live cost variance, daily photo logs, and milestone verification in one system saved us months of potential delays.',
                'rating' => 5,
                'is_featured' => true,
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 1
            ],
            [
                'client_name' => 'Engr. Kamran Siddiqui',
                'client_company' => 'Metropolis Engineering & Infrastructure',
                'client_position' => 'Senior Project Director',
                'testimonial' => 'The task dispatching and daily punch-list workflows kept over 350 field workers and subcontractors aligned with zero guesswork. We delivered Riverside Villas 3 weeks ahead of schedule.',
                'rating' => 5,
                'is_featured' => true,
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 2
            ],
            [
                'client_name' => 'Zainab Qureshi',
                'client_company' => 'Horizon Capital Investments',
                'client_position' => 'Managing Director',
                'testimonial' => 'As an institutional real estate investor, financial transparency is non-negotiable. BrickBeam Earned Value Management and automated monthly audit packs set an entirely new standard in construction management.',
                'rating' => 5,
                'is_featured' => true,
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 3
            ],
            [
                'client_name' => 'David Vance',
                'client_company' => 'Global Logistics & Distribution',
                'client_position' => 'VP of Infrastructure',
                'testimonial' => 'From geotechnical earthworks to final structural handover, BrickBeam digital governance eliminated contractor disputes and gave us real-time peace of mind.',
                'rating' => 5,
                'is_featured' => true,
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 4
            ]
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }

        // 5. Frequently Asked Questions (FAQ)
        $faqs = [
            [
                'question' => 'What is BrickBeam?',
                'answer' => 'BrickBeam is a comprehensive construction management platform and operational suite designed to centralize project planning, field task assignment, team coordination, budget tracking, and real-time progress monitoring into a single unified system.',
                'category' => 'General',
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 1
            ],
            [
                'question' => 'Who can use BrickBeam?',
                'answer' => 'BrickBeam is engineered for General Contractors, Real Estate Developers, Civil Engineering Firms, Architecture Studios, Subcontractor Trade Specialists, and Institutional Project Owners who require transparency and precision in managing construction projects.',
                'category' => 'General',
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 2
            ],
            [
                'question' => 'Can BrickBeam manage multiple projects simultaneously?',
                'answer' => 'Yes. BrickBeam provides an executive multi-project portfolio dashboard allowing leadership to track total capital expenditure, cross-project resource utilization, milestone schedules, and safety benchmarks across all active sites.',
                'category' => 'Features',
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 3
            ],
            [
                'question' => 'How does BrickBeam track project budgets and prevent cost overruns?',
                'answer' => 'BrickBeam utilizes Earned Value Management (EVM), tracking Cost Performance Index (CPI) and Schedule Performance Index (SPI) in real time. It automates 3-way matching of purchase orders and invoices and alerts managers when expenditures approach budget thresholds.',
                'category' => 'Finance',
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 4
            ],
            [
                'question' => 'Can projects be monitored with visual progress and drone mapping?',
                'answer' => 'Yes. BrickBeam integrates high-resolution drone orthomosaics, 360-degree site walkthroughs, and photo-verified task sign-offs, allowing remote stakeholders to inspect progress down to specific columns, slabs, and MEP runs.',
                'category' => 'Technology',
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 5
            ],
            [
                'question' => 'Is BrickBeam suitable for small-to-medium construction teams?',
                'answer' => 'Absolutely. While BrickBeam scales to multi-million dollar high-rise developments, its modular architecture allows boutique contractors and residential custom home builders to start with essential task, budget, and progress tracking modules.',
                'category' => 'General',
                'is_published' => true,
                'is_public_visible' => true,
                'order' => 6
            ]
        ];

        foreach ($faqs as $faq) {
            FAQ::updateOrCreate(['question' => $faq['question']], $faq);
        }

        // 6. Certifications & Standards
        $certifications = [
            ['name' => 'ISO 9001:2015', 'issuing_organization' => 'Quality Management Systems', 'description' => 'Certified high-standard construction quality assurance and execution procedures.'],
            ['name' => 'ISO 45001:2018', 'issuing_organization' => 'Occupational Health & Safety', 'description' => 'Global safety protocol compliance for heavy civil and structural construction sites.'],
            ['name' => 'LEED Gold Standard', 'issuing_organization' => 'US Green Building Council', 'description' => 'Sustainable construction practices, energy modeling, and material lifecycle optimization.'],
            ['name' => 'PEC Category C-A', 'issuing_organization' => 'Pakistan Engineering Council', 'description' => 'Highest classification contractor licensing for high-rise commercial and civil infrastructure.']
        ];

        foreach ($certifications as $idx => $cert) {
            Certification::updateOrCreate(['name' => $cert['name']], [
                'name' => $cert['name'],
                'issuing_organization' => $cert['issuing_organization'],
                'description' => $cert['description'],
                'is_active' => true,
                'is_public_visible' => true,
                'order' => $idx
            ]);
        }

        // 7. Locations
        Location::updateOrCreate(['name' => 'Islamabad Regional HQ'], [
            'address' => 'Floor 9, Tower B, Blue Area',
            'city' => 'Islamabad',
            'state' => 'Federal Capital',
            'zip_code' => '44000',
            'phone' => '+92 (51) 884-2900',
            'email' => 'islamabad@brickbeam.com',
            'is_primary' => true
        ]);

        Location::updateOrCreate(['name' => 'Karachi Coastal Node'], [
            'address' => 'Ocean View Complex, Block 4, Clifton',
            'city' => 'Karachi',
            'state' => 'Sindh',
            'zip_code' => '75600',
            'phone' => '+92 (21) 358-1200',
            'email' => 'karachi@brickbeam.com',
            'is_primary' => false
        ]);
    }
}

