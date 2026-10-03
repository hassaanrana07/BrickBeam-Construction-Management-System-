<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    page: Object,
    team: Array,
    certifications: Array,
    testimonials: Array
});

// Helper to find section by key
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

// 1. Hero Section Data
const heroSec = computed(() => getSection('hero'));
const heroTitle = computed(() => heroSec.value?.heading || heroSec.value?.content?.title || 'WE BUILD MORE THAN STRUCTURES.');
const heroSubtitle = computed(() => heroSec.value?.subheading || heroSec.value?.content?.subtitle || 'SYSTEM ARCHITECTURE & HERITAGE');
const heroDescription = computed(() => heroSec.value?.description || heroSec.value?.content?.description || 'BrickBeam is dedicated to making institutional construction management predictable, transparent, and structurally sound through digital-first engineering and rigorous data governance.');
const heroBtnText = computed(() => heroSec.value?.button_text || heroSec.value?.content?.button_text || 'Platform Capabilities');
const heroBtnLink = computed(() => heroSec.value?.button_link || heroSec.value?.content?.button_link || '/services');
const heroImage = computed(() => resolveImage(heroSec.value?.image_url || heroSec.value?.image || heroSec.value?.content?.image_url || heroSec.value?.content?.image, 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2070'));

// 2. Story Section Data
const storySec = computed(() => getSection('story'));
const storyTitle = computed(() => storySec.value?.heading || storySec.value?.content?.title || 'Our Engineering Story.');
const storySubtitle = computed(() => storySec.value?.subheading || storySec.value?.content?.subtitle || 'GENESIS & PHILOSOPHY');
const storyDescription = computed(() => storySec.value?.description || storySec.value?.content?.description || 'BrickBeam was founded by veteran structural engineers and construction directors who experienced firsthand the severe friction of fragmented jobsite logs, delayed drawing approvals, and budget discrepancies. We engineered an institutional-grade platform connecting every phase of the construction lifecycle: from early geotechnical schematics and BIM coordination to daily field task ticketing, biometric site safety, and automated Earned Value fiscal audits.');
const storyImage = computed(() => resolveImage(storySec.value?.image_url || storySec.value?.image || storySec.value?.content?.image_url || storySec.value?.content?.image, 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070'));

// 3. Mission / Values Section Data
const missionSec = computed(() => getSection('mission_values'));
const missionTitle = computed(() => missionSec.value?.heading || missionSec.value?.content?.title || 'Protocols & Principles');
const missionSubtitle = computed(() => missionSec.value?.subheading || missionSec.value?.content?.subtitle || 'Mission & Core Values');
const missionDescription = computed(() => missionSec.value?.description || missionSec.value?.content?.description || 'Make construction management predictable, transparent, and efficient by eliminating operational blindspots, standardizing field safety gates, and aligning specialty trades to verified milestone telemetry.');

// 4. Pillars Section Data
const pillarsSec = computed(() => getSection('pillars') || getSection('why_choose_us'));
const pillarsTitle = computed(() => pillarsSec.value?.heading || pillarsSec.value?.content?.title || 'Five Architectural Pillars.');
const pillarsSubtitle = computed(() => pillarsSec.value?.subheading || pillarsSec.value?.content?.subtitle || 'SYSTEM ARCHITECTURE');
const pillarsDescription = computed(() => pillarsSec.value?.description || pillarsSec.value?.content?.description || 'Engineered to give general contractors, developers, and project owners complete operational command.');

// 5. Project Models Section Data
const modelsSec = computed(() => getSection('project_models'));
const modelsTitle = computed(() => modelsSec.value?.heading || modelsSec.value?.content?.title || 'Institutional Project Models.');
const modelsSubtitle = computed(() => modelsSec.value?.subheading || modelsSec.value?.content?.subtitle || 'STRUCTURAL DOMAINS');
const modelsDescription = computed(() => modelsSec.value?.description || modelsSec.value?.content?.description || 'Proven capability blueprints deployed across multi-tier construction sectors globally.');

// 6. Values Section Data
const valuesSec = computed(() => getSection('values'));
const valuesTitle = computed(() => valuesSec.value?.heading || valuesSec.value?.content?.title || 'Operational Values.');
const valuesSubtitle = computed(() => valuesSec.value?.subheading || valuesSec.value?.content?.subtitle || 'CORE FOUNDATIONS');
const valuesDescription = computed(() => valuesSec.value?.description || valuesSec.value?.content?.description || 'The bedrock principles guiding every blueprint calculation, field inspection, and audit dossier.');

// 7. Leadership Section Data
const leadershipSec = computed(() => getSection('leadership'));
const leadershipTitle = computed(() => leadershipSec.value?.heading || leadershipSec.value?.content?.title || 'Engineering Leadership.');
const leadershipSubtitle = computed(() => leadershipSec.value?.subheading || leadershipSec.value?.content?.subtitle || 'EXECUTIVE PMO DIRECTORATE');
const leadershipDescription = computed(() => leadershipSec.value?.description || leadershipSec.value?.content?.description || 'Directed by licensed structural engineers, AIA architects, OSHA masters, and capital project executives.');

// 8. CTA Section Data
const ctaSec = computed(() => getSection('cta'));
const ctaTitle = computed(() => ctaSec.value?.heading || ctaSec.value?.content?.title || 'Engineer With Precision.');
const ctaSubtitle = computed(() => ctaSec.value?.subheading || ctaSec.value?.content?.subtitle || 'ENTERPRISE COLLABORATION');
const ctaDescription = computed(() => ctaSec.value?.description || ctaSec.value?.content?.description || 'Partner with BrickBeam to bring modern structural discipline, safety gate verification, and real-time EVM fiscal control to your next development.');
const ctaBtnText = computed(() => ctaSec.value?.button_text || ctaSec.value?.content?.button_text || 'Schedule Technical Consultation');
const ctaBtnLink = computed(() => ctaSec.value?.button_link || ctaSec.value?.content?.button_link || '/contact');

const defaultTeam = [
    {
        name: 'Arthur Beam, PE',
        role: 'Principal Structural Director & Founder',
        badge: 'LICENSE #PE-94021',
        photo: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974',
        bio: 'Over 22 years of structural engineering and EPC project leadership across major high-rise and commercial infrastructure developments.'
    },
    {
        name: 'Sarah Brick, AIA',
        role: 'Chief Architect & BIM Systems Director',
        badge: 'AIA // LEED FELLOW',
        photo: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976',
        bio: 'Specializes in sustainable architectural systems, 4D building information modeling, and high-performance structural envelopes.'
    },
    {
        name: 'Marcus Steel, CSHM',
        role: 'Head of Field Operations & Jobsite Safety',
        badge: 'OSHA MASTER // CSHM',
        photo: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070',
        bio: 'Oversees multi-trade site execution, OSHA-standard safety gates, heavy crane logistics, and critical-path milestone delivery.'
    },
    {
        name: 'Elena Vance, CFA',
        role: 'Director of Construction Capital & EVM',
        badge: 'CFA // EVM SPECIALIST',
        photo: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961',
        bio: 'Expert in capital expenditure tracking, procurement risk assessment, and transparent Earned Value lifecycle management.'
    },
    {
        name: 'David Vance, PE',
        role: 'Structural Telemetry Director',
        badge: 'PE // SENSOR TELEMETRY',
        photo: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=1974',
        bio: 'Directs digital jobsite telemetry, deploying sub-millimeter robotic total stations, drone photogrammetry, and live concrete curing sensors.'
    },
    {
        name: 'Maya Lin, LEED AP',
        role: 'Senior BIM Computational Engineer',
        badge: 'LEED AP BD+C',
        photo: 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=1974',
        bio: 'Specializes in automating federated MEP clash reconciliation, embodied carbon calculations, and fabrication-ready shop model validation.'
    }
];

const pillars = [
    {
        title: 'Centralized Project Command',
        desc: 'Single source of truth uniting blueprints, change orders, field logs, and inspections in one connected workspace.',
        number: '01',
        metric: '< 150ms Telemetry Sync',
        icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
    },
    {
        title: 'Multi-Trade Synchronization',
        desc: 'Bridge the operational gap between architects in the studio, subcontractors on the slab, and owners in the boardroom.',
        number: '02',
        metric: '100% Trade Alignment',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'
    },
    {
        title: 'Real-Time Jobsite Telemetry',
        desc: 'Robotic surveys, 360 virtual site walkthroughs, and photo-verified task logs provide continuous situational awareness.',
        number: '03',
        metric: '±1.0mm Spatial Accuracy',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
    },
    {
        title: 'Earned Value Fiscal Discipline',
        desc: 'Live Cost Performance Index (CPI), automated 3-way invoice matching, and contingency tracking eliminate budget drift.',
        number: '04',
        metric: '< 0.8% Budget Variance',
        icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    },
    {
        title: 'Tamper-Evident Asset Handover',
        desc: 'Turn millions of jobsite data points into predictive schedule forecasting, subcontractor scorecards, and audit-ready dossiers.',
        number: '05',
        metric: '100% Audit-Ready Binders',
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M3 9a9 9 0 0018 0V9a9 9 0 00-18 0zm6 12l-2-2 2-2m6 0l2 2-2 2'
    }
];

const values = [
    {
        title: 'Precision Tolerances',
        desc: 'We enforce sub-millimeter tolerances in structural calculation, digital twin modeling, and field execution.',
        code: 'VAL-01'
    },
    {
        title: 'Institutional Transparency',
        desc: 'Real-time financial variance and daily photo logs ensure owners and lenders always have unfiltered visibility.',
        code: 'VAL-02'
    },
    {
        title: 'Safety Gate Enforceability',
        desc: 'Zero-compromise OSHA standards with mandatory digital biometric toolbox talks and automated hazard mitigation.',
        code: 'VAL-03'
    },
    {
        title: 'Sustainable Longevity',
        desc: 'Integrating low-carbon concrete, solar microgrids, and LEED-compliant lifecycle practices into modern assets.',
        code: 'VAL-04'
    },
    {
        title: 'Digital Twin Telemetry',
        desc: 'Leveraging 4D BIM, robotic total stations, and automated EVM analytics to eliminate jobsite friction.',
        code: 'VAL-05'
    },
    {
        title: 'Fiduciary Partnership',
        desc: 'We operate as trusted co-builders, aligning every milestone with the client long-term financial and operational vision.',
        code: 'VAL-06'
    }
];

const projectModels = [
    {
        id: 'MOD-01',
        title: 'High-Rise Structural Steel & Concrete Cores',
        category: 'Commercial Mega-Structures',
        specs: '50+ Floors // Slipform Core // Tuned Mass Dampers',
        image: 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070'
    },
    {
        id: 'MOD-02',
        title: 'Civic Infrastructure & Multi-Modal Transit Hubs',
        category: 'Heavy Civil Infrastructure',
        specs: 'Post-Tensioned Spans // Sub-Surface Boring // Seismic Grade 9',
        image: 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071'
    },
    {
        id: 'MOD-03',
        title: 'Industrial Energy Hubs & Advanced Logistics Facilities',
        category: 'High-Throughput Industrial',
        specs: '1M+ Sq Ft // Automated Cranes // LEED Platinum Microgrids',
        image: 'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2069'
    }
];

// Pillars Slider State
const pillarIndex = ref(0);
const nextPillar = () => {
    pillarIndex.value = (pillarIndex.value + 1) % pillars.length;
};
const prevPillar = () => {
    pillarIndex.value = (pillarIndex.value - 1 + pillars.length) % pillars.length;
};

// Values Slider State
const valueIndex = ref(0);
const nextValue = () => {
    valueIndex.value = (valueIndex.value + 1) % values.length;
};
const prevValue = () => {
    valueIndex.value = (valueIndex.value - 1 + values.length) % values.length;
};

const fallbackTeamPhoto = 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974';
</script>

<template>
    <PublicLayout>
        <Head title="Architecture & Engineering Heritage — BrickBeam" />

        <!-- 1. HERO SECTION WITH LARGE DEDICATED ARCHITECTURAL BACKGROUND -->
        <section class="relative pt-36 pb-24 lg:pt-48 lg:pb-32 bg-[#0D0D0D] text-white overflow-hidden border-b border-[#242424]">
            <!-- Full-Bleed Architectural Background Image -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
                <img 
                    :src="heroImage" 
                    alt="Architectural Construction Planning & Engineering Blueprints" 
                    class="w-full h-full object-cover object-center filter brightness-[0.35] contrast-125 saturate-[0.8]"
                    loading="eager"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-[#0D0D0D]/75 to-[#0D0D0D]/80"></div>
                <div class="absolute inset-0 cad-grid opacity-25"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 bg-[#171717]/90 border border-[#242424] backdrop-blur-md rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                        <span class="industrial-badge text-[#A3A3A3] text-[9px] tracking-[0.25em]">
                            {{ heroSubtitle }}
                        </span>
                    </div>

                    <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight uppercase leading-[1.02] text-white">
                        {{ heroTitle }}
                    </h1>

                    <p class="text-base sm:text-lg text-[#D4D4D4] leading-relaxed font-normal">
                        {{ heroDescription }}
                    </p>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <Link 
                            :href="heroBtnLink.startsWith('/') ? heroBtnLink : ('/' + heroBtnLink)"
                            class="px-8 py-4 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs rounded-xl shadow-xl shadow-[#E05A1B]/20 transition-all duration-300"
                        >
                            {{ heroBtnText }}
                        </Link>
                        <Link 
                            :href="route('contact')"
                            class="px-8 py-4 bg-[#171717]/90 hover:bg-[#242424] border border-[#383838] hover:border-[#525252] text-[#F3F1EC] font-display font-bold uppercase tracking-wider text-xs rounded-xl transition-all duration-300"
                        >
                            Contact Engineering
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. GENESIS & HERITAGE SECTION -->
        <section class="py-24 bg-[#111111] relative border-b border-[#242424]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left: Text Narrative -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                            <span class="industrial-badge text-[#E05A1B] text-[9px]">{{ storySubtitle }}</span>
                        </div>

                        <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white leading-tight">
                            {{ storyTitle }}
                        </h2>

                        <p class="text-[#F3F1EC] text-base sm:text-lg leading-relaxed font-medium">
                            {{ storyDescription }}
                        </p>

                        <div class="grid grid-cols-2 gap-6 pt-4 border-t border-[#242424]">
                            <div>
                                <h4 class="font-display text-3xl sm:text-4xl font-extrabold text-[#E05A1B] tracking-tight">22+</h4>
                                <p class="industrial-badge text-[9px] text-[#737373] mt-1">YEARS STRUCTURAL PMO EXPERIENCE</p>
                            </div>
                            <div>
                                <h4 class="font-display text-3xl sm:text-4xl font-extrabold text-[#E5A93C] tracking-tight">100%</h4>
                                <p class="industrial-badge text-[9px] text-[#737373] mt-1">AUDIT-READY AS-BUILT COMPLIANCE</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Blueprint & Site Framing -->
                    <div class="lg:col-span-6 relative">
                        <div class="industrial-panel p-3 rounded-2xl relative overflow-hidden bg-[#171717] shadow-2xl corner-crosshair group">
                            <div class="relative aspect-[4/3] rounded-xl overflow-hidden bg-[#0D0D0D]">
                                <img 
                                    :src="storyImage" 
                                    alt="Structural Engineers Reviewing Digital Blueprints" 
                                    class="w-full h-full object-cover filter brightness-[0.75] contrast-120 group-hover:scale-105 transition-transform duration-700 ease-out"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-transparent to-transparent"></div>
                                
                                <div class="absolute bottom-4 left-4 right-4 p-4 bg-[#171717]/95 backdrop-blur-md rounded-xl border border-[#242424]">
                                    <p class="industrial-badge text-[8px] text-[#E05A1B] mb-1">FOUNDATIONAL PRINCIPLE</p>
                                    <p class="font-display text-xs font-bold text-white uppercase">"Every millimeter verified on the digital blueprint protects millions in the field."</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. MISSION & VISION DUAL CONCRETE PANELS -->
        <section class="py-24 bg-[#0D0D0D] border-b border-[#242424] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                    
                    <!-- Mission Card -->
                    <div class="industrial-panel p-8 sm:p-12 rounded-2xl space-y-5 relative overflow-hidden bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/50 transition-all duration-300 shadow-xl corner-crosshair">
                        <div class="w-12 h-12 rounded-xl bg-[#242424] border border-[#383838] flex items-center justify-center text-[#E05A1B] font-display font-bold text-lg">
                            01
                        </div>
                        <h3 class="font-display text-2xl font-bold uppercase tracking-tight text-white">
                            Our Mission<span class="text-[#E05A1B]">.</span>
                        </h3>
                        <p class="text-[#A3A3A3] text-sm leading-relaxed">
                            Make construction management predictable, transparent, and efficient by eliminating operational blindspots, standardizing field safety gates, and aligning specialty trades to verified milestone telemetry.
                        </p>
                        <ul class="space-y-2.5 pt-4 border-t border-[#242424] text-xs text-[#A3A3A3]">
                            <li class="flex items-center gap-2.5">
                                <span class="text-[#E05A1B] font-mono">▸</span>
                                <span>Eliminate chaotic paper logs and fragmented instant messages</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-[#E05A1B] font-mono">▸</span>
                                <span>Deliver predictable budgets with Earned Value telemetry</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Vision Card -->
                    <div class="industrial-panel p-8 sm:p-12 rounded-2xl space-y-5 relative overflow-hidden bg-[#171717] border border-[#242424] hover:border-[#E5A93C]/50 transition-all duration-300 shadow-xl corner-crosshair">
                        <div class="w-12 h-12 rounded-xl bg-[#242424] border border-[#383838] flex items-center justify-center text-[#E5A93C] font-display font-bold text-lg">
                            02
                        </div>
                        <h3 class="font-display text-2xl font-bold uppercase tracking-tight text-white">
                            Our Vision<span class="text-[#E5A93C]">.</span>
                        </h3>
                        <p class="text-[#A3A3A3] text-sm leading-relaxed">
                            Pioneer a connected digital construction future where 4D BIM, total station telemetry, and predictive risk modeling enable zero-defect and zero-accident structural execution worldwide.
                        </p>
                        <ul class="space-y-2.5 pt-4 border-t border-[#242424] text-xs text-[#A3A3A3]">
                            <li class="flex items-center gap-2.5">
                                <span class="text-[#E5A93C] font-mono">▸</span>
                                <span>Establish institutional standards for digital construction governance</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-[#E5A93C] font-mono">▸</span>
                                <span>Enable sustainable, energy-neutral architectural longevity</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. WHY BRICKBEAM? (5 PILLARS WITH SLIDER CONTROLS) -->
        <section class="py-24 bg-[#111111] border-b border-[#242424] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                    <div class="max-w-2xl space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                            <span class="industrial-badge text-[#E05A1B] text-[9px]">{{ pillarsSubtitle }}</span>
                        </div>
                        <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white">
                            {{ pillarsTitle }}
                        </h2>
                        <p class="text-[#A3A3A3] text-sm sm:text-base">
                            {{ pillarsDescription }}
                        </p>
                    </div>

                    <!-- Slider Controls -->
                    <div class="flex items-center gap-3">
                        <button 
                            @click="prevPillar"
                            aria-label="Previous Pillar"
                            class="w-11 h-11 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button 
                            @click="nextPillar"
                            aria-label="Next Pillar"
                            class="w-11 h-11 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- 5 Pillars Display Grid / Carousel -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div 
                        v-for="(pillar, idx) in pillars" 
                        :key="idx"
                        class="industrial-panel p-8 rounded-2xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/60 transition-all duration-300 space-y-5 shadow-xl corner-crosshair group flex flex-col justify-between"
                    >
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-[#242424] pb-4">
                                <span class="industrial-badge text-[9px] text-[#737373]">PILLAR {{ pillar.number }}</span>
                                <div class="w-9 h-9 rounded-lg bg-[#242424] group-hover:bg-[#E05A1B] text-[#A3A3A3] group-hover:text-[#0D0D0D] flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="pillar.icon" /></svg>
                                </div>
                            </div>
                            <h3 class="font-display text-lg font-bold uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">
                                {{ pillar.title }}
                            </h3>
                            <p class="text-[#A3A3A3] text-xs leading-relaxed">
                                {{ pillar.desc }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-[#242424] flex items-center justify-between text-[10px] font-mono">
                            <span class="text-[#737373]">BENCHMARK</span>
                            <span class="text-[#E05A1B] font-bold">{{ pillar.metric }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 5. INSTITUTIONAL PROJECT MODELS & MARKET CAPABILITY SHOWCASE -->
        <section class="py-24 bg-[#0D0D0D] border-b border-[#242424] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="max-w-3xl mb-14 space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">{{ modelsSubtitle }}</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white">
                        {{ modelsTitle }}
                    </h2>
                    <p class="text-[#A3A3A3] text-sm sm:text-base">
                        {{ modelsDescription }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div 
                        v-for="model in projectModels" 
                        :key="model.id"
                        class="industrial-panel bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/60 rounded-2xl overflow-hidden shadow-2xl group transition-all duration-300 corner-crosshair flex flex-col justify-between"
                    >
                        <div class="aspect-[16/10] overflow-hidden bg-[#0D0D0D] relative">
                            <img 
                                :src="model.image" 
                                :alt="model.title"
                                class="w-full h-full object-cover filter brightness-[0.78] contrast-120 group-hover:scale-105 transition-transform duration-700 ease-out"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-transparent to-transparent"></div>
                            
                            <div class="absolute top-3 left-3 px-2.5 py-1 bg-[#0D0D0D]/90 backdrop-blur-md border border-[#242424] rounded text-[9px] font-mono text-[#E05A1B]">
                                {{ model.id }}
                            </div>
                        </div>

                        <div class="p-6 sm:p-7 space-y-4">
                            <span class="industrial-badge text-[8px] text-[#E5A93C] block uppercase">{{ model.category }}</span>
                            <h3 class="font-display text-lg font-bold uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">
                                {{ model.title }}
                            </h3>
                            <div class="pt-4 border-t border-[#242424] text-[10px] font-mono text-[#A3A3A3]">
                                {{ model.specs }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 6. COMPANY VALUES (6 SPECIFICATIONS) -->
        <section class="py-24 bg-[#111111] border-b border-[#242424] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                    <div class="max-w-2xl space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                            <span class="industrial-badge text-[#E05A1B] text-[9px]">{{ valuesSubtitle }}</span>
                        </div>
                        <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white">
                            {{ valuesTitle }}
                        </h2>
                        <p class="text-[#A3A3A3] text-sm">
                            {{ valuesDescription }}
                        </p>
                    </div>

                    <!-- Values Slider / Switcher Controls -->
                    <div class="flex items-center gap-3">
                        <button 
                            @click="prevValue"
                            aria-label="Previous Value"
                            class="w-11 h-11 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button 
                            @click="nextValue"
                            aria-label="Next Value"
                            class="w-11 h-11 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div 
                        v-for="(val, idx) in values" 
                        :key="idx"
                        class="industrial-panel p-8 bg-[#171717] border border-[#242424] rounded-2xl space-y-3 hover:border-[#E05A1B]/50 transition-colors group shadow-xl corner-crosshair"
                    >
                        <span class="industrial-badge text-[9px] text-[#737373] group-hover:text-[#E05A1B] transition-colors">{{ val.code }}</span>
                        <h3 class="font-display text-base font-bold uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">
                            {{ val.title }}
                        </h3>
                        <p class="text-[#A3A3A3] text-xs leading-relaxed">
                            {{ val.desc }}
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 7. LEADERSHIP TEAM SECTION (6 PERSONS) -->
        <section class="py-24 bg-[#0D0D0D] border-b border-[#242424] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-4">
                    <div class="max-w-2xl space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                            <span class="industrial-badge text-[#E05A1B] text-[9px]">{{ leadershipSubtitle }}</span>
                        </div>
                        <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white">
                            {{ leadershipTitle }}
                        </h2>
                        <p class="text-[#A3A3A3] text-sm leading-relaxed">
                            {{ leadershipDescription }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div 
                        v-for="(member, idx) in (team?.length >= 6 ? team : defaultTeam)" 
                        :key="member.id || idx"
                        class="industrial-panel bg-[#171717] border border-[#242424] rounded-2xl overflow-hidden group shadow-xl flex flex-col justify-between hover:border-[#E05A1B]/50 transition-all duration-300 corner-crosshair"
                    >
                        <div class="aspect-[4/3] overflow-hidden bg-[#0D0D0D] relative">
                            <img 
                                :src="member.photo || fallbackTeamPhoto" 
                                @error="($event) => $event.target.src = fallbackTeamPhoto"
                                :alt="member.name"
                                class="w-full h-full object-cover filter brightness-[0.8] contrast-110 group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-transparent to-transparent"></div>
                            
                            <div v-if="member.badge" class="absolute top-3 left-3 px-2.5 py-1 bg-[#0D0D0D]/90 backdrop-blur-md border border-[#242424] rounded text-[9px] font-mono text-[#E05A1B]">
                                {{ member.badge }}
                            </div>
                        </div>

                        <div class="p-6 space-y-2 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-display text-base font-bold uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">
                                    {{ member.name }}
                                </h3>
                                <p class="industrial-badge text-[9px] text-[#E05A1B] mt-0.5">
                                    {{ member.role }}
                                </p>
                                <p v-if="member.bio" class="text-[#A3A3A3] text-xs leading-relaxed pt-2 line-clamp-3">
                                    {{ member.bio }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 8. BOTTOM CTA BANNER -->
        <section class="py-24 bg-[#111111] text-center relative overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">
                <span class="industrial-badge text-[#E05A1B] text-[9px]">{{ ctaSubtitle }}</span>
                
                <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white leading-tight">
                    {{ ctaTitle }}
                </h2>

                <p class="text-[#A3A3A3] text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                    {{ ctaDescription }}
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                    <Link 
                        :href="ctaBtnLink.startsWith('/') ? ctaBtnLink : ('/' + ctaBtnLink)"
                        class="px-8 py-4 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs rounded-xl shadow-lg shadow-[#E05A1B]/20 transition-all duration-300"
                    >
                        {{ ctaBtnText }}
                    </Link>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>
