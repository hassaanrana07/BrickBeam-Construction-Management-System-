<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    services: {
        type: Array,
        default: () => []
    }
});

const defaultModules = [
    {
        title: 'Project Command & Scheduling',
        slug: 'custom-building',
        code: 'SYS-01',
        category: 'COMMAND MATRIX',
        short_description: 'Establish work breakdown structures, critical path timelines, and synchronized BIM/CAD document controls.',
        stats: '100% Critical Path',
        icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'
    },
    {
        title: 'Task & Daily Defect Ticketing',
        slug: 'commercial-renovation',
        code: 'SYS-02',
        category: 'FIELD DISPATCH',
        short_description: 'Assign geo-located checklists, inspect photo verification logs, and eliminate schedule bottlenecks.',
        stats: '4x Defect Velocity',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'
    },
    {
        title: 'Trade & Labor Allocation',
        slug: 'quality-renovation',
        code: 'SYS-03',
        category: 'WORKFORCE OPS',
        short_description: 'Coordinate specialty trades, monitor OSHA safety compliance, and track workforce headcount across sites.',
        stats: 'Zero Headcount Drift',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'
    },
    {
        title: 'Earned Value & Budget Control',
        slug: 'structural-design',
        code: 'SYS-04',
        category: 'FISCAL TELEMETRY',
        short_description: 'Real-time Cost Performance Index (CPI), automated purchase order matching, and cashflow projection.',
        stats: '< 0.8% CPI Variance',
        icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    },
    {
        title: 'Jobsite Milestone Telemetry',
        slug: 'custom-building',
        code: 'SYS-05',
        category: 'SITE TELEMETRY',
        short_description: 'Track physical milestone percentages against engineering baselines with automated delay forecast alerts.',
        stats: 'Real-time Sync',
        icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'
    },
    {
        title: 'Executive Analytics & Dossiers',
        slug: 'commercial-renovation',
        code: 'SYS-06',
        category: 'AUDIT & HANDOVER',
        short_description: 'Export tamper-evident stakeholder reports, financial variance dossiers, and owner turnover documentation.',
        stats: 'Instant PDF Export',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
    }
];

const modulesList = computed(() => {
    if (props.services && props.services.length >= 4) {
        return props.services.map((s, idx) => ({
            title: s.title,
            slug: s.slug || defaultModules[idx % defaultModules.length].slug,
            code: `SYS-0${idx + 1}`,
            category: s.structural_type || 'CAPABILITY MODULE',
            short_description: s.short_description || defaultModules[idx % defaultModules.length].short_description,
            stats: defaultModules[idx % defaultModules.length].stats,
            icon: defaultModules[idx % defaultModules.length].icon
        }));
    }
    return defaultModules;
});

// Carousel state
const activeIndex = ref(0);
const trackRef = ref(null);
const isPaused = ref(false);
let autoPlayInterval = null;

const nextSlide = () => {
    activeIndex.value = (activeIndex.value + 1) % modulesList.value.length;
};

const prevSlide = () => {
    activeIndex.value = (activeIndex.value - 1 + modulesList.value.length) % modulesList.value.length;
};

const goToSlide = (index) => {
    activeIndex.value = index;
};

onMounted(() => {
    autoPlayInterval = setInterval(() => {
        if (!isPaused.value) {
            nextSlide();
        }
    }, 4500);
});

onUnmounted(() => {
    if (autoPlayInterval) clearInterval(autoPlayInterval);
});
</script>

<template>
    <section 
        id="capabilities-section" 
        class="py-24 bg-[#111111] border-t border-[#242424] relative overflow-hidden"
        @mouseenter="isPaused = true"
        @mouseleave="isPaused = false"
    >
        <!-- Background Grid -->
        <div class="absolute inset-0 cad-dots opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header & Carousel Controls -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6 border-b border-[#242424] pb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">CAPABILITIES CAROUSEL</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                        Core System Modules<span class="text-[#E05A1B]">.</span>
                    </h2>
                </div>

                <!-- Navigation Controls -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button 
                            @click="prevSlide"
                            class="p-2.5 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white transition-all shadow-md"
                            aria-label="Previous capability"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button 
                            @click="nextSlide"
                            class="p-2.5 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white transition-all shadow-md"
                            aria-label="Next capability"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <Link 
                        :href="route('services')"
                        class="hidden sm:inline-flex items-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-[#E05A1B] transition-colors pl-4 border-l border-[#242424]"
                    >
                        <span>All Capabilities</span>
                        <span>→</span>
                    </Link>
                </div>
            </div>

            <!-- Carousel Display Container -->
            <div class="overflow-hidden relative">
                <div 
                    ref="trackRef"
                    class="flex transition-transform duration-500 ease-out gap-6"
                    :style="{ transform: `translateX(-${activeIndex * 33.333}%)` }"
                >
                    <!-- Slides duplicated for smooth wrap-around appearance -->
                    <div 
                        v-for="(mod, idx) in [...modulesList, ...modulesList]" 
                        :key="idx"
                        class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] flex-shrink-0"
                    >
                        <Link 
                            :href="route('services.show', mod.slug)"
                            class="industrial-panel p-8 rounded-2xl flex flex-col justify-between group relative overflow-hidden shadow-xl corner-crosshair h-full min-h-[340px] bg-[#171717] hover:border-[#E05A1B]/50 transition-all duration-300"
                        >
                            <div>
                                <!-- Top Strip -->
                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#242424]">
                                    <span class="industrial-badge text-[9px] text-[#525252] group-hover:text-[#E05A1B] transition-colors">
                                        {{ mod.code }} // {{ mod.category }}
                                    </span>
                                    <div class="w-10 h-10 rounded-xl bg-[#242424] group-hover:bg-[#E05A1B] text-[#A3A3A3] group-hover:text-[#0D0D0D] flex items-center justify-center transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="mod.icon"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Title & Description -->
                                <h3 class="font-display text-xl font-bold uppercase text-white group-hover:text-[#E05A1B] transition-colors mb-3">
                                    {{ mod.title }}
                                </h3>
                                <p class="text-[#A3A3A3] text-xs leading-relaxed line-clamp-3">
                                    {{ mod.short_description }}
                                </p>
                            </div>

                            <!-- Bottom Metrics & CTA -->
                            <div class="pt-6 mt-6 border-t border-[#242424] flex items-center justify-between">
                                <div>
                                    <span class="industrial-badge text-[8px] text-[#525252] block">BENCHMARK</span>
                                    <span class="font-display text-xs font-bold text-[#E5A93C]">{{ mod.stats }}</span>
                                </div>
                                <div class="flex items-center gap-1 text-xs font-display font-semibold uppercase tracking-wider text-[#A3A3A3] group-hover:text-white transition-colors">
                                    <span>Specs</span>
                                    <span class="text-[#E05A1B] font-bold group-hover:translate-x-1 transition-transform">→</span>
                                </div>
                            </div>

                            <!-- Bottom Accent Line -->
                            <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-[#E05A1B] group-hover:w-full transition-all duration-500"></div>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Dots Indicator Navigation -->
            <div class="flex items-center justify-center gap-2 mt-8">
                <button 
                    v-for="(_, idx) in modulesList" 
                    :key="idx"
                    @click="goToSlide(idx)"
                    class="h-1.5 rounded-full transition-all duration-300"
                    :class="activeIndex === idx ? 'w-8 bg-[#E05A1B]' : 'w-2 bg-[#242424] hover:bg-[#525252]'"
                    :aria-label="`Slide ${idx + 1}`"
                />
            </div>

        </div>
    </section>
</template>
