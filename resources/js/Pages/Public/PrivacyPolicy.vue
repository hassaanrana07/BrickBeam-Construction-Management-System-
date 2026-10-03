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
const heroTitle = computed(() => heroSec.value?.heading || heroSec.value?.content?.title || 'PRIVACY POLICY.');
const heroSubtitle = computed(() => heroSec.value?.subheading || heroSec.value?.content?.subtitle || 'LEGAL & COMPLIANCE');
const heroDescription = computed(() => heroSec.value?.description || heroSec.value?.content?.description || 'Effective Date: 2026 • Enterprise Construction Security Protocol');
const heroImage = computed(() => resolveImage(heroSec.value?.image_url || heroSec.value?.image || heroSec.value?.content?.image_url || heroSec.value?.content?.image, 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'));

// Legal Content Sections
const defaultLegalSections = [
    {
        title: '1. Architectural Data Governance Overview',
        desc: 'BrickBeam ("we," "our," or "the Platform") provides an institutional-grade construction management software ecosystem. We are committed to safeguarding project documentation, architectural models, financial baselines, and team telemetry ingested into our systems.'
    },
    {
        title: '2. Information We Ingest & Process',
        desc: 'Account Information: Name, professional title, corporate email, phone, and company authorization credentials. Jobsite Telemetry: Geo-tagged inspection photos, daily task logs, drone survey uploads, and milestone timestamps. Financial & BOQ Data: Purchase orders, cost codes, earned value indices, and contractor payment draw records. Device & Access Logs: IP addresses, browser fingerprinting, audit trail stamps, and biometric verification tokens where enabled.'
    },
    {
        title: '3. How Information is Utilized',
        desc: 'Data processed on BrickBeam is strictly utilized to deliver critical path project management, automated variance calculation, multi-trade task routing, and tamper-evident audit dossier generation. We do not sell or monetize proprietary construction drawings or financial estimates to third parties.'
    },
    {
        title: '4. Security & Encryption Standards',
        desc: 'All jobsite transmissions and cloud repositories are protected by AES-256 encryption at rest and TLS 1.3 in transit. Multi-factor authentication (MFA) and strict role-based access control (RBAC) ensure that subcontractors only view allocated tasks while general contractors and project owners retain full portfolio visibility.'
    },
    {
        title: '5. Contact Legal & Security Desk',
        desc: 'For inquiries regarding privacy, data audits, or compliance dossiers, please reach our governance team at: Email: privacy@brickbeam.com • Operational PMO Desk: +92 (51) 884-2900'
    }
];

const legalSections = computed(() => {
    const list = props.page?.sections || props.page?.contentSections || [];
    const filtered = list.filter(s => s.section_key === 'legal_content' || s.type === 'legal_content');
    if (filtered.length > 0) {
        return filtered.map((s, idx) => ({
            title: s.heading || s.content?.title || `Section ${idx + 1}`,
            desc: s.description || s.content?.description || ''
        }));
    }
    return defaultLegalSections;
});

// CTA Action Data
const lastSection = computed(() => {
    const list = props.page?.sections || props.page?.contentSections || [];
    const withBtn = list.find(s => s.button_text || s.content?.button_text);
    return withBtn;
});
const ctaBtnText = computed(() => lastSection.value?.button_text || lastSection.value?.content?.button_text || 'Contact Compliance Officer');
const ctaBtnLink = computed(() => lastSection.value?.button_link || lastSection.value?.content?.button_link || '/contact');
</script>

<template>
    <PublicLayout>
        <Head title="Privacy Policy — BrickBeam Construction Platform" />

        <!-- 1. HERO SECTION -->
        <section class="relative pt-36 pb-20 lg:pt-48 lg:pb-24 bg-[#0D0D0D] text-white border-b border-[#242424] overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none">
                <img 
                    :src="heroImage" 
                    alt="BrickBeam Security and Compliance" 
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

        <!-- 2. POLICY CONTENT -->
        <section class="py-20 lg:py-28 bg-[#0D0D0D] text-[#D4D4D4]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 leading-relaxed text-sm sm:text-base">
                
                <div 
                    v-for="(section, idx) in legalSections" 
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

