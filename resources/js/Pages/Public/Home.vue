<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';
import ArchitecturalHero from '@/Components/Public/Sections/ArchitecturalHero.vue';
import CredibilityMetrics from '@/Components/Public/Sections/CredibilityMetrics.vue';
import PinnedWorkflowSection from '@/Components/Public/Sections/PinnedWorkflowSection.vue';
import InteractiveDashboardPreview from '@/Components/Public/Sections/InteractiveDashboardPreview.vue';
import CapabilityModuleSlider from '@/Components/Public/Sections/CapabilityModuleSlider.vue';
import ProjectShowcaseSlider from '@/Components/Public/Sections/ProjectShowcaseSlider.vue';
import DevelopmentProtocol from '@/Components/Public/Sections/DevelopmentProtocol.vue';
import EngineerPortfolioSlider from '@/Components/Public/Sections/EngineerPortfolioSlider.vue';
import ArchitecturalTestimonials from '@/Components/Public/Sections/ArchitecturalTestimonials.vue';
import ArchitecturalCTA from '@/Components/Public/Sections/ArchitecturalCTA.vue';

const props = defineProps({
    page: Object,
    featured_services: Array,
    projects: Array,
    team: Array,
    testimonials: Array,
    faqs: Array
});
</script>

<template>
    <PublicLayout>
        <Head title="BrickBeam — Institutional Construction Management System" />

        <!-- 1. Architectural Hero Section with Full-Bleed Background Visual & Dynamic CMS Binding -->
        <ArchitecturalHero :page="page" />

        <!-- 2. CAD Credibility Metrics with Animated Counters -->
        <CredibilityMetrics :page="page" />

        <!-- 3. Pinned Horizontal Workflow Section (GSAP ScrollTrigger - 100% viewport visible) -->
        <PinnedWorkflowSection />

        <!-- 4. Interactive Live Dashboard Telemetry Preview -->
        <InteractiveDashboardPreview />

        <!-- 5. Infinite Horizontal Capability Module Carousel -->
        <CapabilityModuleSlider :services="featured_services" />

        <!-- 6. 3D Project Showcase Carousel with Strictly Unique Imagery -->
        <ProjectShowcaseSlider :projects="projects" />

        <!-- 7. 6-Phase Development Protocol Component -->
        <DevelopmentProtocol />

        <!-- 8. Executive Engineering Directorate Slider -->
        <EngineerPortfolioSlider :engineers="team" />

        <!-- 9. Industry Testimonials & Client Dossiers -->
        <ArchitecturalTestimonials :testimonials="testimonials" />

        <!-- 10. Engineering Deployment CTA -->
        <ArchitecturalCTA :page="page" />
    </PublicLayout>
</template>
