<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show($slug = 'overview')
    {
        $aliases = [
            'home' => ['overview', 'home'],
            'overview' => ['overview', 'home'],
            'about' => ['architect', 'about'],
            'architect' => ['architect', 'about'],
            'services' => ['capabilities', 'services'],
            'capabilities' => ['capabilities', 'services'],
            'portfolio' => ['project', 'portfolio', 'projects'],
            'project' => ['project', 'portfolio', 'projects'],
            'projects' => ['project', 'portfolio', 'projects'],
            'contact' => ['contact'],
            'faqs' => ['faqs', 'faq'],
            'faq' => ['faqs', 'faq'],
            'privacy-policy' => ['privacy-policy'],
            'terms-and-conditions' => ['terms-and-conditions'],
            'footer' => ['footer'],
        ];

        $slugList = $aliases[$slug] ?? [$slug];

        $page = Page::whereIn('slug', $slugList)->where('status', 'published')->first();
        if (!$page) {
            $page = Page::whereIn('slug', $slugList)->first();
        }

        if ($page) {
            $page->load([
                'contentSections' => function ($query) {
                    $query->where('is_active', true)->orderBy('order');
                }
            ]);
            $page->setRelation('sections', $page->contentSections);
        }

        $data = [
            'page' => $page ?? (object)[
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'sections' => []
            ]
        ];

        // Architect / About Page
        if (in_array($slug, ['about', 'architect'])) {
            $data['team'] = \App\Models\Staff::where('is_active', true)
                ->where('is_public_visible', true)
                ->orderBy('order')
                ->get();
            $data['certifications'] = \App\Models\Certification::where('is_active', true)
                ->where('is_public_visible', true)
                ->orderBy('order')
                ->get();
            $data['testimonials'] = \App\Models\Testimonial::where('is_published', true)
                ->where('is_public_visible', true)
                ->orderBy('order')
                ->take(4)
                ->get();

            return Inertia::render('Public/About', $data);
        }

        // Privacy Policy Page
        if ($slug === 'privacy-policy') {
            return Inertia::render('Public/PrivacyPolicy', $data);
        }

        // Terms and Conditions Page
        if ($slug === 'terms-and-conditions') {
            return Inertia::render('Public/TermsAndConditions', $data);
        }

        if (!$page) {
            abort(404);
        }

        return Inertia::render('Public/Page', $data);
    }
}

