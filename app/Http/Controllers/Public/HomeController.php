<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $page = Page::whereIn('slug', ['overview', 'home'])->first();
        if ($page) {
            $page->load([
                'contentSections' => function ($q) {
                    $q->where('is_active', true)->orderBy('order');
                }
            ]);
            $page->setRelation('sections', $page->contentSections);
        }

        $services = Service::where('status', 'published')
            ->where('is_public_visible', true)
            ->where('is_public', true)
            ->orderBy('order')
            ->get();

        $projects = Portfolio::where('status', 'published')
            ->where('is_public_visible', true)
            ->where('is_public', true)
            ->orderBy('order')
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'location' => $p->location,
                'short_description' => $p->short_description,
                'featured_image' => $p->featured_image,
                'project_type' => $p->project_type,
                'is_featured' => $p->is_featured,
                'execution_status' => $p->execution_status ?? 'In Progress',
                'budget' => $p->budget_range ?: ('PKR ' . ($p->total_budget ? number_format($p->total_budget / 1000000, 1) . 'M' : '50M+')),
                'progress' => $p->execution_status === 'Completed' ? 100 : ($p->cs_phase_4 ? 85 : ($p->cs_phase_3 ? 65 : ($p->cs_phase_2 ? 40 : 25))),
            ]);

        $testimonials = Testimonial::where('is_published', true)
            ->where('is_public_visible', true)
            ->orderBy('order')
            ->get();

        $faqs = \App\Models\FAQ::where('is_published', true)
            ->where('is_public_visible', true)
            ->orderBy('order')
            ->get();

        $team = \App\Models\Staff::where('is_active', true)
            ->where('is_public_visible', true)
            ->orderBy('order')
            ->get();

        return Inertia::render('Public/Home', [
            'page' => $page,
            'featured_services' => $services,
            'projects' => $projects,
            'team' => $team,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
        ]);
    }
}
