<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const phases = [
    {
        step: '01',
        title: 'Geotechnical & Reconnaissance',
        tagline: 'Subterranean Profiling & Baseline Audits',
        description: 'Subterranean core borehole sampling, seismic fault-line profiling, drone LiDAR topography mapping, and baseline structural load feasibility audits before ground is broken.',
        deliverables: ['Geotechnical Core Borehole Report', 'LiDAR Topographical CAD File', 'Environmental Subsurface Impact Study'],
        image: 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?q=80&w=2070',
        stats: { metric: '0.00 mm', label: 'Ground Settlement Tolerance' },
        icon: 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'
    },
    {
        step: '02',
        title: 'Structural Planning & Feasibility',
        tagline: 'Cost Engineering & CPM Baselines',
        description: 'Formulate rigorous Work Breakdown Structures (WBS), Earned Value cost baselines, long-lead supply chain procurement matrices, and municipal regulatory zoning clearance.',
        deliverables: ['Earned Value Cost Baseline (EVM)', 'Critical Path Method (CPM) Schedule', 'Procurement Long-Lead Registry'],
        image: 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2070',
        stats: { metric: '100%', label: 'Permit & Regulatory Clearance' },
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
    },
    {
        step: '03',
        title: 'BIM 4D Modeling & Clash Detection',
        tagline: '4D Digital Twin Orchestration',
        description: 'Generate comprehensive 4D BIM digital twins, automate trade clash detection across structural and MEP systems, and validate parametric geometry before steel fabrication.',
        deliverables: ['Federated 4D BIM Model', 'Zero-Clash Clearance Audit', 'Fabrication-Ready Shop Drawings'],
        image: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=2070',
        stats: { metric: '0 Clashes', label: 'Pre-Fabrication Conflict Rate' },
        icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
    },
    {
        step: '04',
        title: 'Heavy Construction & Field Execution',
        tagline: 'Precision Concrete & Steel Erection',
        description: 'Subterranean micropiling, post-tensioned slab casting, structural steel erection, and continuous millimeter-grade alignment via robotic total stations and crane logistics.',
        deliverables: ['Concrete Compression Break Tests', 'Crane Lift Telemetry Logs', 'Daily Biometric Sign-Off Sheets'],
        image: 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
        stats: { metric: '±1.0 mm', label: 'Robotic Alignment Precision' },
        icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
    },
    {
        step: '05',
        title: 'Quality Assurance & Telemetry',
        tagline: 'Non-Destructive Testing & Safety Gates',
        description: 'Deploy ultrasonic non-destructive weld testing, thermal building envelope thermography, automated safety gate compliance, and real-time Earned Value variance detection.',
        deliverables: ['Ultrasonic NDT Certificates', 'Building Envelope Thermography', 'Safety Incident Zero-Log'],
        image: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070',
        stats: { metric: '0 Incidents', label: 'OSHA Safety Gate Verification' },
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M3 9a9 9 0 0018 0V9a9 9 0 00-18 0zm6 12l-2-2 2-2m6 0l2 2-2 2'
    },
    {
        step: '06',
        title: 'Commissioning & Handover',
        tagline: 'Tamper-Evident Asset Transfer',
        description: 'Execute multi-zone MEP balancing, municipal occupancy certification, and compile complete tamper-evident digital twin binders for seamless long-term facility management.',
        deliverables: ['Turnkey As-Built Digital Twin', 'Occupancy Certification Dossier', '10-Year Structural Warranty Binder'],
        image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
        stats: { metric: '100%', label: 'Turnkey Facility Readiness' },
        icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
    }
];

const activeIndex = ref(0);
let autoplayInterval = null;

const nextPhase = () => {
    activeIndex.value = (activeIndex.value + 1) % phases.length;
};

const prevPhase = () => {
    activeIndex.value = (activeIndex.value - 1 + phases.length) % phases.length;
};

const selectPhase = (idx) => {
    activeIndex.value = idx;
};

const startAutoplay = () => {
    stopAutoplay();
    autoplayInterval = setInterval(() => {
        nextPhase();
    }, 7000);
};

const stopAutoplay = () => {
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
        autoplayInterval = null;
    }
};

onMounted(() => {
    startAutoplay();
});

onUnmounted(() => {
    stopAutoplay();
});
</script>

<template>
    <section 
        class="py-24 bg-[#111111] border-t border-[#242424] relative overflow-hidden text-white"
        @mouseenter="stopAutoplay"
        @mouseleave="startAutoplay"
    >
        <!-- Background Architectural CAD Dots -->
        <div class="absolute inset-0 cad-dots opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">ENGINEERING PROTOCOL</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                        The 6-Phase Development Protocol<span class="text-[#E05A1B]">.</span>
                    </h2>
                    <p class="text-[#A3A3A3] text-sm sm:text-base leading-relaxed">
                        A rigorous digital-first construction lifecycle methodology engineered to guarantee structural integrity, budget compliance, and zero schedule drift.
                    </p>
                </div>

                <!-- Prev/Next Controls -->
                <div class="flex items-center gap-3">
                    <button 
                        @click="prevPhase"
                        aria-label="Previous Phase"
                        class="w-11 h-11 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button 
                        @click="nextPhase"
                        aria-label="Next Phase"
                        class="w-11 h-11 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step Selector Tabs (Desktop & Tablet) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-10">
                <button
                    v-for="(phase, idx) in phases"
                    :key="phase.step"
                    @click="selectPhase(idx)"
                    class="p-3.5 rounded-xl text-left border transition-all duration-300 relative group overflow-hidden flex flex-col justify-between min-h-[85px]"
                    :class="activeIndex === idx 
                        ? 'bg-[#171717] border-[#E05A1B] shadow-xl ring-1 ring-[#E05A1B]/40' 
                        : 'bg-[#171717]/40 border-[#242424] hover:border-[#525252] hover:bg-[#171717]'"
                >
                    <div class="flex items-center justify-between w-full">
                        <span 
                            class="font-display text-sm font-bold transition-colors"
                            :class="activeIndex === idx ? 'text-[#E05A1B]' : 'text-[#737373] group-hover:text-white'"
                        >
                            PHASE {{ phase.step }}
                        </span>
                        <span 
                            class="w-1.5 h-1.5 rounded-full transition-colors"
                            :class="activeIndex === idx ? 'bg-[#E05A1B]' : 'bg-transparent'"
                        ></span>
                    </div>
                    <p 
                        class="text-[11px] font-display font-bold uppercase truncate mt-2 transition-colors"
                        :class="activeIndex === idx ? 'text-white' : 'text-[#A3A3A3] group-hover:text-white'"
                    >
                        {{ phase.title }}
                    </p>
                </button>
            </div>

            <!-- Interactive Spotlight Showcase Feature for Active Phase -->
            <div class="industrial-panel bg-[#171717] border border-[#242424] rounded-2xl overflow-hidden shadow-2xl p-6 sm:p-10 corner-crosshair">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left: Phase Details & Deliverables -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-[#242424] text-[#E05A1B] text-xs font-mono font-bold rounded-lg border border-[#383838]">
                                GATEWAY {{ phases[activeIndex].step }} // VERIFIED
                            </span>
                            <span class="industrial-badge text-[9px] text-[#E5A93C]">
                                {{ phases[activeIndex].tagline }}
                            </span>
                        </div>

                        <h3 class="font-display text-2xl sm:text-4xl font-extrabold uppercase text-white tracking-tight">
                            {{ phases[activeIndex].title }}
                        </h3>

                        <p class="text-[#D4D4D4] text-sm sm:text-base leading-relaxed">
                            {{ phases[activeIndex].description }}
                        </p>

                        <!-- Deliverables List -->
                        <div class="space-y-2.5 pt-4 border-t border-[#242424]">
                            <span class="industrial-badge text-[8px] text-[#737373] block uppercase tracking-widest">
                                GATE DELIVERABLES & DOCUMENTATION
                            </span>
                            <div 
                                v-for="(deliv, dIdx) in phases[activeIndex].deliverables" 
                                :key="dIdx"
                                class="flex items-center gap-3 text-xs sm:text-sm text-[#A3A3A3]"
                            >
                                <span class="text-[#E05A1B] font-mono font-bold">▸</span>
                                <span class="text-white font-medium">{{ deliv }}</span>
                            </div>
                        </div>

                        <!-- Metric Badge -->
                        <div class="pt-4 border-t border-[#242424] flex items-center justify-between">
                            <div>
                                <span class="industrial-badge text-[8px] text-[#737373] block">OPERATIONAL BENCHMARK</span>
                                <span class="font-display text-xl font-bold text-[#E05A1B]">{{ phases[activeIndex].stats.metric }}</span>
                            </div>
                            <span class="text-xs text-[#A3A3A3] font-mono">{{ phases[activeIndex].stats.label }}</span>
                        </div>
                    </div>

                    <!-- Right: Phase Cinematic Visual -->
                    <div class="lg:col-span-6 relative">
                        <div class="relative aspect-[16/10] sm:aspect-[16/9] rounded-xl overflow-hidden bg-[#0D0D0D] border border-[#242424] shadow-2xl group">
                            <img 
                                :src="phases[activeIndex].image" 
                                :alt="phases[activeIndex].title"
                                class="w-full h-full object-cover filter brightness-[0.8] contrast-120 group-hover:scale-105 transition-transform duration-700 ease-out"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-transparent to-transparent opacity-80"></div>
                            
                            <!-- Overlay Phase Stamp -->
                            <div class="absolute top-4 left-4 px-3 py-1 bg-[#0D0D0D]/90 backdrop-blur-md border border-[#242424] rounded text-[10px] font-mono text-[#E05A1B]">
                                PROTOCOL PHASE 0{{ activeIndex + 1 }} // ACTIVE
                            </div>

                            <div class="absolute bottom-4 left-4 right-4 p-4 bg-[#171717]/95 backdrop-blur-md border border-[#242424] rounded-xl flex items-center justify-between">
                                <div>
                                    <span class="industrial-badge text-[8px] text-[#A3A3A3] block">STATUS</span>
                                    <span class="font-display text-xs font-bold text-white uppercase">DIGITAL GATE CLEARED</span>
                                </div>
                                <span class="text-xs font-mono text-emerald-400 font-bold">100% AUDITED</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</template>
