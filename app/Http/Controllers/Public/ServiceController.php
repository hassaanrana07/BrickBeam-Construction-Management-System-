<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $page = \App\Models\Page::whereIn('slug', ['capabilities', 'services'])->where('status', 'published')->first();

        if ($page) {
            $page->load([
                'contentSections' => function ($query) {
                    $query->where('is_active', true)->orderBy('order');
                }
            ]);
            $page->setRelation('sections', $page->contentSections);
        }

        return Inertia::render('Public/Services/Index', [
            'page' => $page,
            'services' => Service::where(function($q) {
                    $q->where('status', 'published')->orWhereNull('status');
                })
                ->latest()
                ->get(),
            'estimation_rules' => \App\Models\CostEstimatorRule::where('is_active', true)->orderBy('order')->get()
        ]);
    }

    public function show(Service $service)
    {
        if ($service->status === 'archived') {
            abort(404);
        }

        return Inertia::render('Public/Services/Show', [
            'service' => $service,
            'related_services' => Service::where('id', '!=', $service->id)
                ->where('status', '!=', 'archived')
                ->take(3)
                ->get()
        ]);
    }
}
