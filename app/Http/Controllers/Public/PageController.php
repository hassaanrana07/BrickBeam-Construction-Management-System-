<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show($slug = 'home')
    {
        $page = Page::where('slug', $slug)->where('status', 'published')->first();

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

        if ($slug === 'about') {
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

        if (!$page) {
            abort(404);
        }

        return Inertia::render('Public/Page', $data);
    }
}
