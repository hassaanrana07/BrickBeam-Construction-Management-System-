<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index()
    {
        $page = \App\Models\Page::where('slug', 'portfolio')->where('status', 'published')->first();

        if ($page) {
            $page->load([
                'contentSections' => function ($query) {
                    $query->where('is_active', true)->orderBy('order');
                }
            ]);
            $page->setRelation('sections', $page->contentSections);
        }

        return Inertia::render('Public/Portfolio/Index', [
            'page' => $page,
            'projects' => Portfolio::where(function($q) {
                    $q->where('status', 'published')->orWhereNull('status');
                })
                ->orderBy('order')
                ->latest()
                ->get()
                ->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'title' => $project->title,
                        'slug' => $project->slug,
                        'short_description' => $project->short_description,
                        'location' => $project->location,
                        'featured_image' => $project->featured_image,
                        'project_type' => $project->project_type,
                        'is_featured' => $project->is_featured,
                        'execution_status' => $project->execution_status ?? 'In Progress',
                        'budget' => $project->budget_range ?: ('PKR ' . ($project->total_budget ? number_format($project->total_budget / 1000000, 1) . 'M' : '50M+')),
                        'progress' => $project->execution_status === 'Completed' ? 100 : ($project->cs_phase_4 ? 85 : ($project->cs_phase_3 ? 65 : ($project->cs_phase_2 ? 40 : 25))),
                    ];
                })
        ]);
    }

    public function show(Portfolio $portfolio)
    {
        if ($portfolio->status === 'archived') {
            abort(404);
        }

        $project = [
            'id' => $portfolio->id,
            'title' => $portfolio->title,
            'slug' => $portfolio->slug,
            'description' => $portfolio->description,
            'short_description' => $portfolio->short_description,
            'location' => $portfolio->location,
            'client_name' => $portfolio->client_name ?? 'Confidential Enterprise Client',
            'project_type' => $portfolio->project_type,
            'start_date' => $portfolio->start_date ? $portfolio->start_date->format('M Y') : 'Q1 2024',
            'completion_date' => $portfolio->completion_date ? $portfolio->completion_date->format('M Y') : 'Q4 2025',
            'execution_status' => $portfolio->execution_status ?? 'In Progress',
            'progress' => $portfolio->execution_status === 'Completed' ? 100 : ($portfolio->cs_phase_4 ? 85 : ($portfolio->cs_phase_3 ? 65 : ($portfolio->cs_phase_2 ? 40 : 25))),
            'budget' => $portfolio->budget_range ?: ('PKR ' . ($portfolio->total_budget ? number_format($portfolio->total_budget / 1000000, 1) . 'M' : '85M')),
            'featured_image' => $portfolio->featured_image,
            'gallery' => $portfolio->gallery ?? [
                'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070',
                'https://images.unsplash.com/photo-1504917595217-d4dc5f566fab?q=80&w=2070',
                'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
            ],
            // Case Study fields
            'case_study_category' => $portfolio->case_study_category ?? 'Commercial Infrastructure',
            'case_study_scope' => $portfolio->case_study_scope ?? 'Full-Scale EPC Management',
            'case_study_sector' => $portfolio->case_study_sector ?? $portfolio->project_type,
            'cs_phase_1' => $portfolio->cs_phase_1 ?? 'Planning & Feasibility Analysis',
            'cs_phase_2' => $portfolio->cs_phase_2 ?? 'Substructure & Foundation Engineering',
            'cs_phase_3' => $portfolio->cs_phase_3 ?? 'Superstructure & MEP Coordination',
            'cs_phase_4' => $portfolio->cs_phase_4 ?? 'Interior Fit-Out & Smart Facades',
            'cs_phase_5' => $portfolio->cs_phase_5 ?? 'Quality Audit & Handover Commissioning',
            'cs_duration_weeks' => $portfolio->cs_duration_weeks ?? '36',
            'cs_team' => $portfolio->cs_team ?? 'Structural Engineering Taskforce Alpha',
            'cs_total_value' => $portfolio->cs_total_value ?? ($portfolio->budget_range ?: 'PKR 120M'),
            // Structure Analysis
            'structural_features' => $portfolio->structural_features ?? [
                'High-grade reinforced concrete core with post-tensioned slabs',
                'Seismic grade damping dampers and wind resistance engineering',
                'BIM Level 3 integration with real-time field synchronization',
                'Smart building automation & energy efficiency envelope'
            ],
            'base_structure' => $portfolio->base_structure ?? 'Composite Steel & Reinforced Concrete',
            'foundation_type' => $portfolio->foundation_type ?? 'Deep Bored Pile Foundation',
            'total_floors' => $portfolio->total_floors ?? 14,
            'floor_composition' => $portfolio->floor_composition ?? 'Post-Tensioned Concrete',
            'capabilities' => $portfolio->capabilities ?? [
                'Automated progress tracking with drone surveying',
                'Subcontractor safety and compliance monitoring',
                'Live budget variance and procurement analytics',
                'Milestone deadline auditing with critical path analysis'
            ],
            'functional_features' => $portfolio->functional_features ?? [
                'LEED Gold sustainability certifications',
                'Advanced acoustic dampening & double-glazed low-E facades',
                'Integrated rainwater harvesting and greywater recycling'
            ],
            'technology_used' => $portfolio->technology_used ?? 'Revit, Navisworks, Procore, Primavera P6',
            'construction_technology' => $portfolio->construction_technology ?? 'Prefabricated Precast Facades & Post-Tensioned Floor Plates',
            'tools_used' => $portfolio->tools_used ?? ['AutoCAD', 'Revit BIM', 'Primavera P6', 'DroneDeploy', 'ETABS'],
            'framework_type' => $portfolio->framework_type ?? 'Agile CPM & Lean Construction Matrix',
        ];

        return Inertia::render('Public/Portfolio/Show', [
            'project' => $project
        ]);
    }
}
