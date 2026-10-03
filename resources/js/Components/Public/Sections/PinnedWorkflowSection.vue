<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const containerRef = ref(null);
const sliderRef = ref(null);

const pillars = [
    {
        code: 'MOD-01',
        number: '01',
        title: 'Project Command',
        subtitle: 'Unified Blueprint & Schedule Engine',
        description: 'Establish work breakdown structures, critical path timelines, and synchronized BIM/CAD document controls in a single multi-tenant workspace.',
        metric: '100% Critical Path Visibility',
        metricLabel: 'Schedule Adherence',
        icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'
    },
    {
        code: 'MOD-02',
        number: '02',
        title: 'Earned Value Finance',
        subtitle: 'Predictive Cost & PO Verification',
        description: 'Eliminate cost surprises. Track Cost Performance Index (CPI) and Schedule Performance Index (SPI) in real-time with automated 3-way invoice matching.',
        metric: '< 0.8% Budget Variance',
        metricLabel: 'Variance Elimination',
        icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    },
    {
        code: 'MOD-03',
        number: '03',
        title: 'Field & Trade Dispatch',
        subtitle: 'Photo-Verified Daily Sign-Offs',
        description: 'Equip foremen and trade contractors with mobile checklists, safety gate protocols, geo-tagged photo inspections, and instant defect ticketing.',
        metric: '4x Faster Defect Resolution',
        metricLabel: 'Field Execution Rate',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'
    },
    {
        code: 'MOD-04',
        number: '04',
        title: 'Milestone Turnover',
        subtitle: 'Tamper-Evident Handover Dossiers',
        description: 'Generate comprehensive owner handover binders, compliance certifications, audit trails, and financial reconciliations upon final project completion.',
        metric: 'Instant Audit Turnover',
        metricLabel: 'Owner Sign-Off Gate',
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M3 9a9 9 0 0018 0V9a9 9 0 00-18 0zm6 12l-2-2 2-2m6 0l2 2-2 2'
    }
];

let ctx = null;

onMounted(() => {
    const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (isDesktop && !prefersReducedMotion && containerRef.value && sliderRef.value) {
        ctx = gsap.context(() => {
            const panels = gsap.utils.toArray('.workflow-panel');
            const totalPanels = panels.length;
            
            gsap.to(panels, {
                xPercent: -100 * (totalPanels - 1),
                ease: 'none',
                scrollTrigger: {
                    trigger: containerRef.value,
                    pin: true,
                    anticipatePin: 1,
                    scrub: 1,
                    snap: 1 / (totalPanels - 1),
                    start: 'top top',
                    end: () => '+=' + (sliderRef.value.scrollWidth - window.innerWidth + 200),
                    invalidateOnRefresh: true,
                }
            });
        }, containerRef.value);
    }
});

onUnmounted(() => {
    if (ctx) {
        ctx.revert();
    }
});
</script>

<template>
    <div 
        ref="containerRef" 
        class="relative bg-[#0D0D0D] border-t border-[#242424] overflow-hidden lg:h-screen lg:flex lg:flex-col lg:justify-between py-12 lg:py-10"
    >
        <!-- Top Section Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-[#242424] pb-5">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">END-TO-END WORKFLOW</span>
                    </div>
                    <h2 class="font-display text-2xl sm:text-4xl lg:text-5xl font-extrabold uppercase text-white tracking-tight">
                        Integrated Project Control<span class="text-[#E05A1B]">.</span>
                    </h2>
                </div>
                <p class="text-[#A3A3A3] text-xs sm:text-sm max-w-md font-normal leading-relaxed">
                    Four synchronized operational phases engineered for zero variance from groundbreaking to final turnover.
                </p>
            </div>
        </div>

        <!-- Horizontal Slider Container (Desktop: GSAP Horizontal / Mobile: Stack) -->
        <div 
            ref="sliderRef" 
            class="flex flex-col lg:flex-row lg:flex-nowrap lg:w-[400%] px-4 sm:px-6 lg:px-8 py-6 lg:py-4 gap-6 lg:gap-8 max-w-7xl mx-auto w-full"
        >
            <div 
                v-for="(pillar, idx) in pillars" 
                :key="idx" 
                class="workflow-panel w-full lg:w-screen max-w-none lg:max-w-[70vw] flex-shrink-0"
            >
                <div class="industrial-panel p-6 sm:p-10 rounded-2xl relative overflow-hidden flex flex-col justify-between corner-crosshair shadow-2xl lg:max-h-[58vh] bg-[#171717]">
                    
                    <!-- Card Top Header -->
                    <div class="flex items-center justify-between border-b border-[#242424] pb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-[#E05A1B]"></span>
                            <span class="industrial-badge text-[#A3A3A3] text-[10px]">{{ pillar.code }} // PHASE {{ pillar.number }}</span>
                        </div>
                        <span class="font-display text-3xl sm:text-4xl font-extrabold text-[#242424]">{{ pillar.number }}</span>
                    </div>

                    <!-- Card Body Content -->
                    <div class="my-5 space-y-3">
                        <div class="w-11 h-11 rounded-xl bg-[#242424] border border-[#383838] flex items-center justify-center text-[#E05A1B]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="pillar.icon"/>
                            </svg>
                        </div>

                        <div>
                            <span class="industrial-badge text-[10px] text-[#E5A93C] block mb-1">{{ pillar.subtitle }}</span>
                            <h3 class="font-display text-xl sm:text-2xl font-bold uppercase text-white tracking-tight">
                                {{ pillar.title }}
                            </h3>
                        </div>

                        <p class="text-[#A3A3A3] text-xs sm:text-sm leading-relaxed max-w-2xl line-clamp-3">
                            {{ pillar.description }}
                        </p>
                    </div>

                    <!-- Card Bottom Metric Bar (Always 100% visible) -->
                    <div class="pt-4 border-t border-[#242424] flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <span class="industrial-badge text-[9px] text-[#525252] block">{{ pillar.metricLabel }}</span>
                            <span class="font-display text-base sm:text-lg font-bold text-white">{{ pillar.metric }}</span>
                        </div>
                        <div class="flex items-center gap-2 industrial-badge text-[10px] text-[#E05A1B]">
                            <span>OPERATIONAL COMPONENT</span>
                            <span>→</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bottom Navigation Guide Bar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full hidden lg:flex items-center justify-between text-xs text-[#525252] pt-2">
            <span class="industrial-badge text-[9px]">SCROLL TO PROGRESS PHASES // 01 — 04</span>
            <span class="font-mono text-[9px] text-[#A3A3A3]">BRICKBEAM CORE ENGINE</span>
        </div>
    </div>
</template>
