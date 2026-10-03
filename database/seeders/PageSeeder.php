<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageSection;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Overview',
                'slug' => 'overview',
                'legacy_slugs' => ['home'],
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'BRICKBEAM',
                            'subtitle' => 'BUILD. MANAGE. CONTROL.',
                            'description' => 'Centralize multi-trade ticketing, Earned Value budgets, biometric jobsite safety gates, and 4D BIM digital twins into one unified command center.',
                            'button_text' => 'Explore Project Portfolio',
                            'button_link' => '/projects',
                            'image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
                        ]
                    ],
                    [
                        'type' => 'credibility',
                        'content' => [
                            'title' => 'The Numbers of Excellence',
                            'subtitle' => 'CAD Credibility Metrics',
                            'description' => 'Track record of high-density structural coordination and EVM budget control across commercial and residential developments.'
                        ]
                    ],
                    [
                        'type' => 'about',
                        'content' => [
                            'title' => 'Built for the way construction projects actually work.',
                            'subtitle' => 'ABOUT BRICKBEAM',
                            'description' => 'BrickBeam brings projects, teams, tasks, budgets, and progress into one connected workspace — giving construction teams a clearer way to plan work, monitor execution, and keep projects moving.',
                            'button_text' => 'DISCOVER METHODOLOGY',
                            'button_link' => '/about'
                        ]
                    ],
                    [
                        'type' => 'technical_services',
                        'content' => [
                            'title' => 'Technical Services',
                            'subtitle' => 'Capability Matrix',
                            'description' => 'From geotechnical analysis and BIM coordination to structural engineering and turnkey project delivery.'
                        ]
                    ],
                    [
                        'type' => 'why_choose_us',
                        'content' => [
                            'title' => 'The Brick & Beam Advantage',
                            'subtitle' => 'Engineering Protocol',
                            'description' => 'Sub-millimeter spatial tolerances, real-time telemetry sync, and transparent Earned Value fiscal management.'
                        ]
                    ],
                    [
                        'type' => 'featured_projects',
                        'content' => [
                            'title' => 'Flagship Projects',
                            'subtitle' => 'Architectural Archive',
                            'description' => 'Commercial mega-structures, heavy civil infrastructure, and sustainable residential developments.'
                        ]
                    ],
                    [
                        'type' => 'cta',
                        'content' => [
                            'title' => 'Ready to Command Your Next Construction Project?',
                            'subtitle' => 'ENGINEERING DEPLOYMENT',
                            'description' => 'Deploy BrickBeam across your development portfolio to eliminate budget variances, sync specialty trades, and ensure verified milestone delivery.',
                            'button_text' => 'Schedule Engineering Briefing',
                            'button_link' => '/contact'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Architect',
                'slug' => 'architect',
                'legacy_slugs' => ['about'],
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'WE BUILD MORE THAN STRUCTURES.',
                            'subtitle' => 'SYSTEM ARCHITECTURE & HERITAGE',
                            'description' => 'BrickBeam is dedicated to making institutional construction management predictable, transparent, and structurally sound through digital-first engineering and rigorous data governance.',
                            'button_text' => 'Platform Capabilities',
                            'button_link' => '/services',
                            'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2070',
                        ]
                    ],
                    [
                        'type' => 'story',
                        'content' => [
                            'title' => 'Our Engineering Story.',
                            'subtitle' => 'GENESIS & PHILOSOPHY',
                            'description' => 'BrickBeam was founded by veteran structural engineers and construction directors who experienced firsthand the severe friction of fragmented jobsite logs, delayed drawing approvals, and budget discrepancies. We engineered an institutional-grade platform connecting every phase of the construction lifecycle: from early geotechnical schematics and BIM coordination to daily field task ticketing, biometric site safety, and automated Earned Value fiscal audits.',
                            'image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
                        ]
                    ],
                    [
                        'type' => 'mission_values',
                        'content' => [
                            'title' => 'Protocols & Principles',
                            'subtitle' => 'Mission & Core Values',
                            'description' => 'Make construction management predictable, transparent, and efficient by eliminating operational blindspots, standardizing field safety gates, and aligning specialty trades to verified milestone telemetry.'
                        ]
                    ],
                    [
                        'type' => 'pillars',
                        'content' => [
                            'title' => 'Five Architectural Pillars.',
                            'subtitle' => 'SYSTEM ARCHITECTURE',
                            'description' => 'Engineered to give general contractors, developers, and project owners complete operational command through centralized blueprints, multi-trade sync, real-time telemetry, EVM discipline, and audit-ready asset handover.'
                        ]
                    ],
                    [
                        'type' => 'project_models',
                        'content' => [
                            'title' => 'Institutional Project Models.',
                            'subtitle' => 'STRUCTURAL DOMAINS',
                            'description' => 'Proven capability blueprints deployed across multi-tier construction sectors globally: High-Rise Structural Steel, Civic Infrastructure, and Industrial Energy Hubs.'
                        ]
                    ],
                    [
                        'type' => 'values',
                        'content' => [
                            'title' => 'Operational Values.',
                            'subtitle' => 'CORE FOUNDATIONS',
                            'description' => 'Precision Tolerances, Institutional Transparency, Safety Gate Enforceability, Sustainable Longevity, Digital Twin Telemetry, and Fiduciary Partnership.'
                        ]
                    ],
                    [
                        'type' => 'leadership',
                        'content' => [
                            'title' => 'Engineering Leadership.',
                            'subtitle' => 'EXECUTIVE PMO DIRECTORATE',
                            'description' => 'Directed by licensed structural engineers, AIA architects, OSHA masters, and capital project executives.'
                        ]
                    ],
                    [
                        'type' => 'cta',
                        'content' => [
                            'title' => 'Engineer With Precision.',
                            'subtitle' => 'ENTERPRISE COLLABORATION',
                            'description' => 'Partner with BrickBeam to bring modern structural discipline, safety gate verification, and real-time EVM fiscal control to your next development.',
                            'button_text' => 'Schedule Technical Consultation',
                            'button_link' => '/contact'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Capabilities',
                'slug' => 'capabilities',
                'legacy_slugs' => ['services'],
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'SYSTEM CAPABILITIES.',
                            'subtitle' => 'TECHNICAL CAPABILITIES SPECIFICATION',
                            'description' => 'Enterprise-grade construction management modules engineered for high-density structural coordination, EVM budget control, and turnkey delivery.',
                            'button_text' => 'Explore Capabilities',
                            'button_link' => '/services',
                            'image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
                        ]
                    ],
                    [
                        'type' => 'service_list',
                        'content' => [
                            'title' => 'Operational Verticals',
                            'subtitle' => 'Specialized Capabilities Grid',
                            'description' => 'Comprehensive modules including Custom Building, Commercial Renovation, Quality Renovation, and Structural Design.'
                        ]
                    ],
                    [
                        'type' => 'pricing',
                        'content' => [
                            'title' => 'Structural Cost Calculator',
                            'subtitle' => 'ESTIMATION ENGINE',
                            'description' => 'Our real-time parametric estimation engine calculates baseline capital requirements and critical path delivery weeks based on active material logistics indices.',
                            'button_text' => 'LAUNCH ESTIMATOR',
                            'button_link' => '/estimate'
                        ]
                    ],
                    [
                        'type' => 'cta',
                        'content' => [
                            'title' => 'Deploy System Modules Across Your Active Jobsite',
                            'subtitle' => 'ENTERPRISE DEPLOYMENT',
                            'description' => 'Integrate BrickBeam into your construction workflow for real-time progress visibility and verified milestone delivery.',
                            'button_text' => 'Initiate Full Engineering Dossier',
                            'button_link' => '/contact'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Project',
                'slug' => 'project',
                'legacy_slugs' => ['portfolio', 'projects'],
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'PROJECTS BUILT WITH PRECISION.',
                            'subtitle' => 'PROJECT PORTFOLIO & AS-BUILT DOSSIERS',
                            'description' => 'Explore our track record of high-performance commercial towers, bespoke luxury residences, and industrial logistics facilities engineered through BrickBeam.',
                            'button_text' => 'View Flagship Work',
                            'button_link' => '/projects',
                            'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                        ]
                    ],
                    [
                        'type' => 'project_list',
                        'content' => [
                            'title' => 'The Matrix of Completions',
                            'subtitle' => 'Active & Handed-Over Developments',
                            'description' => 'Detailed case studies with structural telemetry, concrete core specs, and Earned Value completion metrics.'
                        ]
                    ],
                    [
                        'type' => 'before_after',
                        'content' => [
                            'title' => 'Structural Evolution',
                            'subtitle' => 'Transformation Analysis',
                            'description' => 'Comparative before-and-after spatial analysis from ground-breaking to full commissioning.'
                        ]
                    ],
                    [
                        'type' => 'testimonials',
                        'content' => [
                            'title' => 'Peer Verification',
                            'subtitle' => 'Stakeholder Testimonials',
                            'description' => 'Client reviews from leading real estate developers and general contracting partners.'
                        ]
                    ],
                    [
                        'type' => 'cta',
                        'content' => [
                            'title' => 'Deploy With Precision.',
                            'subtitle' => 'CAPITAL PROJECT INCEPTION',
                            'description' => 'Bring institutional transparency, precision scheduling, and EVM budget control to your active portfolio.',
                            'button_text' => 'Schedule Project Inception',
                            'button_link' => '/contact'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => "LET'S BUILD BETTER TOGETHER.",
                            'subtitle' => 'CONNECT WITH ENGINEERING',
                            'description' => 'Have a project, RFP, or system integration query? Connect with our structural PMO and technical directors.',
                            'button_text' => 'Submit Technical RFP',
                            'button_link' => '/contact',
                            'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
                        ]
                    ],
                    [
                        'type' => 'contact_form',
                        'content' => [
                            'title' => 'Inquiry Terminal',
                            'subtitle' => 'Direct PMO Transmission',
                            'description' => 'Submit project parameters, drawings, or general inquiries directly to our engineering coordination desk.'
                        ]
                    ],
                    [
                        'type' => 'contact_info',
                        'content' => [
                            'title' => 'HQ Locations & Regional Nodes',
                            'subtitle' => 'Operational Hubs',
                            'description' => 'Direct hotlines and offices across Islamabad HQ, Lahore Hub, and Karachi Ops.'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faqs',
                'legacy_slugs' => ['faq'],
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'OPERATIONS & PLATFORM FAQ.',
                            'subtitle' => 'KNOWLEDGE ACCESS & PROTOCOLS',
                            'description' => 'Standard operating procedures, Earned Value metrics, telemetry synchronization, and frequently requested data.',
                            'button_text' => 'Submit New Question',
                            'button_link' => '/contact',
                            'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                        ]
                    ],
                    [
                        'type' => 'faq_list',
                        'content' => [
                            'title' => 'Common Technical Protocols',
                            'subtitle' => 'Architecture & Workflow Answers',
                            'description' => 'Frequently asked questions regarding BIM synchronization, contractor access levels, and budget control.'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'PRIVACY POLICY.',
                            'subtitle' => 'LEGAL & COMPLIANCE',
                            'description' => 'Effective Date: 2026 • Enterprise Construction Security Protocol',
                            'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '1. Architectural Data Governance Overview',
                            'subtitle' => 'Data Protection',
                            'description' => 'BrickBeam ("we," "our," or "the Platform") provides an institutional-grade construction management software ecosystem. We are committed to safeguarding project documentation, architectural models, financial baselines, and team telemetry ingested into our systems.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '2. Information We Ingest & Process',
                            'subtitle' => 'Data Collection Scope',
                            'description' => 'Account Information: Name, professional title, corporate email, phone, and company authorization credentials. Jobsite Telemetry: Geo-tagged inspection photos, daily task logs, drone survey uploads, and milestone timestamps. Financial & BOQ Data: Purchase orders, cost codes, earned value indices, and contractor payment draw records.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '3. How Information is Utilized',
                            'subtitle' => 'Operational Usage',
                            'description' => 'Data processed on BrickBeam is strictly utilized to deliver critical path project management, automated variance calculation, multi-trade task routing, and tamper-evident audit dossier generation. We do not sell or monetize proprietary construction drawings or financial estimates to third parties.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '4. Security & Encryption Standards',
                            'subtitle' => 'AES-256 & TLS 1.3',
                            'description' => 'All jobsite transmissions and cloud repositories are protected by AES-256 encryption at rest and TLS 1.3 in transit. Multi-factor authentication (MFA) and strict role-based access control (RBAC) ensure that subcontractors only view allocated tasks while general contractors and project owners retain full portfolio visibility.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '5. Contact Legal & Security Desk',
                            'subtitle' => 'Compliance Verification',
                            'description' => 'For inquiries regarding privacy, data audits, or compliance dossiers, please reach our governance team at: Email: privacy@brickbeam.com • Operational PMO Desk: +92 (51) 884-2900',
                            'button_text' => 'Contact Compliance Officer',
                            'button_link' => '/contact'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'sections' => [
                    [
                        'type' => 'hero',
                        'content' => [
                            'title' => 'TERMS & CONDITIONS.',
                            'subtitle' => 'SERVICE AGREEMENT & MASTER TERMS',
                            'description' => 'Effective Date: 2026 • Enterprise Construction Management Platform Agreement',
                            'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '1. Acceptance of Terms',
                            'subtitle' => 'Agreement Scope',
                            'description' => 'By accessing, testing, or deploying the BrickBeam construction management platform, you agree to abide by these Master Terms and Conditions. These terms govern all jobsite modules, API integrations, digital change order tracking, and client portal functions.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '2. Platform License & Permitted Use',
                            'subtitle' => 'Enterprise Licensing',
                            'description' => 'BrickBeam grants customer organizations a non-exclusive, non-transferable enterprise license to coordinate construction operations, schedule tasks, issue RFIs, log safety sign-offs, and track budget performance for authorized projects.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '3. Jobsite Safety & Professional Responsibility',
                            'subtitle' => 'Professional Compliance',
                            'description' => 'While BrickBeam provides digital tracking tools, daily checklists, and safety documentation repositories, licensed engineers of record, project managers, and general contractors remain solely responsible for structural compliance, OSHA standards, physical site safety, and building code conformance.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '4. Intellectual Property & Customer Drawings',
                            'subtitle' => 'Customer Ownership',
                            'description' => 'All proprietary BIM files, architectural drawings, engineering schematics, and custom budget worksheets uploaded by clients remain the exclusive intellectual property of the respective client or authoring studio. BrickBeam claims no ownership over ingested construction assets.'
                        ]
                    ],
                    [
                        'type' => 'legal_content',
                        'content' => [
                            'title' => '5. Uptime & SLA Guarantees',
                            'subtitle' => '99.9% Uptime Commitment',
                            'description' => 'BrickBeam maintains an institutional 99.9% uptime Service Level Agreement for core operational databases, field sync endpoints, and executive dashboards. Scheduled maintenance windows are communicated at least 48 hours in advance.',
                            'button_text' => 'Initiate Project Consultation',
                            'button_link' => '/contact'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Footer',
                'slug' => 'footer',
                'sections' => [
                    [
                        'type' => 'footer_branding',
                        'content' => [
                            'title' => 'BrickBeam Platform',
                            'subtitle' => 'Enterprise Construction System',
                            'description' => 'Enterprise construction management platform engineered to centralize project planning, daily field ticketing, trade coordination, and real-time Earned Value budget telemetry.'
                        ]
                    ],
                    [
                        'type' => 'footer_links',
                        'content' => [
                            'title' => 'Navigation Grid',
                            'subtitle' => 'System Verticals',
                            'description' => 'Overview, Architecture, Capabilities, Projects, Contact, FAQ, Privacy Policy, Terms & Conditions'
                        ]
                    ]
                ]
            ]
        ];

        foreach ($pages as $pData) {
            $slugsToCheck = array_merge([$pData['slug']], $pData['legacy_slugs'] ?? []);
            
            $page = Page::withTrashed()->whereIn('slug', $slugsToCheck)->first();
            
            if ($page) {
                if ($page->trashed()) {
                    $page->restore();
                }
                $page->update([
                    'title' => $pData['title'],
                    'slug' => $pData['slug'],
                    'status' => 'published'
                ]);
            } else {
                $page = Page::create([
                    'title' => $pData['title'],
                    'slug' => $pData['slug'],
                    'status' => 'published'
                ]);
            }

            // Clean old sections and re-seed with authentic rich content
            $page->contentSections()->delete();

            foreach ($pData['sections'] as $index => $sData) {
                $page->contentSections()->create([
                    'section_key' => $sData['type'],
                    'heading' => $sData['content']['title'] ?? null,
                    'subheading' => $sData['content']['subtitle'] ?? null,
                    'description' => $sData['content']['description'] ?? null,
                    'button_text' => $sData['content']['button_text'] ?? null,
                    'button_link' => $sData['content']['button_link'] ?? null,
                    'image' => $sData['content']['image'] ?? null,
                    'order' => $index,
                    'is_active' => true
                ]);
            }
        }
    }
}

