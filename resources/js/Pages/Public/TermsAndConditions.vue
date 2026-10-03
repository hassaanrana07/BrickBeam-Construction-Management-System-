<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    page: Object
});

const getSection = (key) => {
    const list = props.page?.sections || props.page?.contentSections || [];
    return list.find(s => s.section_key === key || s.type === key);
};

const resolveImage = (path, fallback) => {
    if (!path) return fallback;
    if (typeof path !== 'string') return fallback;
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

// Hero Section Data
const heroSec = computed(() => getSection('hero'));
const heroTitle = computed(() => heroSec.value?.heading || heroSec.value?.content?.title || 'TERMS & CONDITIONS.');
const heroSubtitle = computed(() => heroSec.value?.subheading || heroSec.value?.content?.subtitle || 'SERVICE AGREEMENT & MASTER TERMS');
const heroDescription = computed(() => heroSec.value?.description || heroSec.value?.content?.description || 'Effective Date: 2026 • Enterprise Construction Management Platform Agreement');
const heroImage = computed(() => resolveImage(heroSec.value?.image_url || heroSec.value?.image || heroSec.value?.content?.image_url || heroSec.value?.content?.image, 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071'));

// Terms Content Sections
const defaultTermsSections = [
    {
        title: '1. Acceptance of Terms',
        desc: 'By accessing, testing, or deploying the BrickBeam construction management platform, you agree to abide by these Master Terms and Conditions. These terms govern all jobsite modules, API integrations, digital change order tracking, and client portal functions.'
    },
    {
        title: '2. Platform License & Permitted Use',
        desc: 'BrickBeam grants customer organizations a non-exclusive, non-transferable enterprise license to coordinate construction operations, schedule tasks, issue RFIs, log safety sign-offs, and track budget performance for authorized projects.'
    },
    {
        title: '3. Jobsite Safety & Professional Responsibility',
        desc: 'While BrickBeam provides digital tracking tools, daily checklists, and safety documentation repositories, licensed engineers of record, project managers, and general contractors remain solely responsible for structural compliance, OSHA standards, physical site safety, and building code conformance.'
    },
    {
        title: '4. Intellectual Property & Customer Drawings',
        desc: 'All proprietary BIM files, architectural drawings, engineering schematics, and custom budget worksheets uploaded by clients remain the exclusive intellectual property of the respective client or authoring studio. BrickBeam claims no ownership over ingested construction assets.'
    },
    {
        title: '5. Uptime & SLA Guarantees',
        desc: 'BrickBeam maintains an institutional 99.9% uptime Service Level Agreement for core operational databases, field sync endpoints, and executive dashboards. Scheduled maintenance windows are communicated at least 48 hours in advance.'
    }
];

const termsSections = computed(() => {
    const list = props.page?.sections || props.page?.contentSections || [];
    const filtered = list.filter(s => s.section_key === 'legal_content' || s.type === 'legal_content');
    if (filtered.length > 0) {
        return filtered.map((s, idx) => ({
            title: s.heading || s.content?.title || `Section ${idx + 1}`,
            desc: s.description || s.content?.description || ''
        }));
    }
    return defaultTermsSections;
});

// CTA Action Data
const lastSection = computed(() => {
    const list = props.page?.sections || props.page?.contentSections || [];
    const withBtn = list.find(s => s.button_text || s.content?.button_text);
    return withBtn;
});
const ctaBtnText = computed(() => lastSection.value?.button_text || lastSection.value?.content?.button_text || 'Initiate Project Consultation');
const ctaBtnLink = computed(() => lastSection.value?.button_link || lastSection.value?.content?.button_link || '/contact');
</script>

<template>
    <PublicLayout>
        <Head title="Terms & Conditions — BrickBeam Construction Platform" />

        <!-- 1. HERO SECTION -->
        <section class="relative pt-36 pb-20 lg:pt-48 lg:pb-24 bg-[#0D0D0D] text-white border-b border-[#242424] overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img 
                    :src="heroImage" 
                    alt="BrickBeam Terms and Governance" 
                    class="w-full h-full object-cover filter brightness-[0.25] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-[#0D0D0D]/80 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#0D0D0D]/95 via-[#0D0D0D]/70 to-transparent"></div>
                <div class="absolute inset-0 cad-grid opacity-20"></div>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#171717]/90 border border-[#242424] rounded-full backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                        <span class="industrial-badge text-[9px] tracking-[0.25em] text-[#A3A3A3]">
                            {{ heroSubtitle }}
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-display font-black tracking-tight uppercase leading-tight text-white">
                        {{ heroTitle }}
                    </h1>

                    <p class="text-[#A3A3A3] text-sm sm:text-base">
                        {{ heroDescription }}
                    </p>
                </div>
            </div>
        </section>

        <!-- 2. TERMS CONTENT -->
        <section class="py-20 lg:py-28 bg-[#0D0D0D] text-[#D4D4D4]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 leading-relaxed text-sm sm:text-base">
                
                <div 
                    v-for="(section, idx) in termsSections" 
                    :key="idx" 
                    class="p-8 bg-[#171717] border border-[#242424] rounded-2xl space-y-4 hover:border-[#E05A1B]/40 transition-colors"
                >
                    <h2 class="text-lg font-display font-black uppercase text-white tracking-tight flex items-center gap-3">
                        <span 
                            class="w-2 h-5 rounded-full"
                            :class="idx % 2 === 0 ? 'bg-[#E05A1B]' : 'bg-[#E5A93C]'"
                        ></span>
                        {{ section.title }}
                    </h2>
                    <p class="text-[#A3A3A3] text-sm leading-relaxed whitespace-pre-line">
                        {{ section.desc }}
                    </p>
                </div>

                <div class="pt-6 text-center">
                    <Link 
                        :href="ctaBtnLink.startsWith('/') ? ctaBtnLink : ('/' + ctaBtnLink)"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-widest text-xs rounded-xl transition-all duration-200 shadow-xl shadow-[#E05A1B]/20"
                    >
                        <span>{{ ctaBtnText }}</span>
                        <span>→</span>
                    </Link>
                </div>

            </div>
        </section>

    </PublicLayout>
</template>

