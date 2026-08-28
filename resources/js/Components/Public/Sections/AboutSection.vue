<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import ArchitecturalBuildingViewer from './AboutSection/ArchitecturalBuildingViewer.vue';

const props = defineProps({
    content: {
        type: Object,
        default: () => ({})
    },
    globalData: {
        type: Object,
        default: () => ({})
    }
});

// Construction Story Progression Stages
const currentStage = ref(4);
const viewerRef = ref(null);

const stages = [
    { id: 1, key: 'planning', label: '1. Foundation', sub: 'Substructure & Grid' },
    { id: 2, key: 'structure', label: '2. Structure', sub: 'Framing & Columns' },
    { id: 3, key: 'enclosure', label: '3. Enclosure', sub: 'Envelope & Glazing' },
    { id: 4, key: 'completed', label: '4. Completed', sub: 'Integrated Project' },
];

const setStage = (stageId) => {
    currentStage.value = stageId;
};

// 4 Core Capabilities
const iconMap = {
    'home-icon': 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    'building-icon': 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
    'factory-icon': 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
};

const getIconPath = (icon) => {
    if (icon && (icon.startsWith('M') || icon.startsWith('m'))) return icon;
    if (icon && iconMap[icon]) return iconMap[icon];
    return 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4';
};

const capabilities = [
    {
        title: 'PROJECT MANAGEMENT',
        desc: 'Plan projects, organize work, and keep every stage visible.',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'
    },
    {
        title: 'TEAM COLLABORATION',
        desc: 'Keep project teams aligned around tasks, responsibilities, and progress.',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
    },
    {
        title: 'TASK & PROGRESS TRACKING',
        desc: 'Monitor work across projects and quickly identify what needs attention.',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
    },
    {
        title: 'BUDGET CONTROL',
        desc: 'Keep project costs organized and make financial information easier to monitor.',
        icon: 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'
    }
];
</script>

<template>
    <section id="about-section" class="py-24 lg:py-32 bg-[#080d18] text-white relative overflow-hidden">
        <!-- Blueprint Grid & Architectural Crosshairs -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-20 pointer-events-none"></div>

        <!-- Ambient Accent Glow -->
        <div class="absolute top-1/3 left-1/4 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Architectural Header Metadata Line -->
            <div class="flex items-center justify-between border-b border-slate-800/80 pb-4 mb-16">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-none bg-amber-400"></span>
                    <span class="text-[11px] font-mono font-bold uppercase tracking-[0.35em] text-amber-400">
                        {{ content.label || 'ABOUT BRICKBEAM' }}
                    </span>
                </div>
                <div class="hidden sm:flex items-center gap-6 text-[10px] font-mono text-slate-500 uppercase tracking-widest">
                    <span>SECT: 02.A</span>
                    <span>/</span>
                    <span>ARCHITECTURAL WORKSPACE</span>
                </div>
            </div>

            <!-- Two-Column Main Composition -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                <!-- Left Column: Company Narrative & Capabilities (5 Cols) -->
                <div class="lg:col-span-5 space-y-10">
                    <!-- Heading Block -->
                    <div class="space-y-6">
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-[1.12] text-white">
                            {{ content.heading || 'Built for the way construction projects actually work.' }}
                        </h2>
                        
                        <p class="text-slate-300 text-base sm:text-lg leading-relaxed font-normal">
                            {{ content.description || 'BrickBeam brings projects, teams, tasks, budgets, and progress into one connected workspace — giving construction teams a clearer way to plan work, monitor execution, and keep projects moving.' }}
                        </p>

                        <p class="text-slate-400 text-sm leading-relaxed border-l-2 border-amber-400/40 pl-4 py-1 italic font-medium">
                            {{ content.secondary_description || 'From the first project plan to the final stage of construction, BrickBeam keeps the people, work, and information behind every project organized in one place.' }}
                        </p>
                    </div>

                    <!-- Clean Technical Divider -->
                    <div class="w-full h-[1px] bg-gradient-to-r from-slate-800 via-slate-700 to-transparent"></div>

                    <!-- 4 Core Capabilities (Clean Minimal Text/Icon Grid, No Fake Statistics) -->
                    <div class="space-y-6">
                        <div class="text-[10px] font-mono font-bold uppercase tracking-[0.25em] text-slate-400">
                            CORE PLATFORM CAPABILITIES
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div 
                                v-for="item in capabilities" 
                                :key="item.title"
                                class="space-y-2 group"
                            >
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-amber-400 group-hover:border-amber-400/50 group-hover:bg-amber-400/10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" :d="getIconPath(item.icon)" />
                                        </svg>
                                    </div>
                                    <h4 class="text-xs font-black uppercase tracking-wider text-white group-hover:text-amber-400 transition-colors">
                                        {{ item.title }}
                                    </h4>
                                </div>
                                <p class="text-xs text-slate-400 leading-relaxed pl-11">
                                    {{ item.desc }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Optional Architectural Link -->
                    <div class="pt-4 flex items-center gap-4">
                        <Link 
                            :href="content.button_link || route('about')" 
                            class="inline-flex items-center gap-3 px-6 py-3.5 bg-slate-900 hover:bg-slate-800 border border-slate-700 text-xs font-mono font-bold uppercase tracking-widest text-white rounded-xl transition-all hover:border-amber-400/50 group"
                        >
                            <span>{{ content.button_text || 'DISCOVER METHODOLOGY' }}</span>
                            <svg class="w-4 h-4 text-amber-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </Link>
                    </div>
                </div>

                <!-- Right Column: 3D Architectural Scene & Construction Progression (7 Cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- 3D Real-time Architectural Construction Scene -->
                    <div class="relative">
                        <ArchitecturalBuildingViewer 
                            ref="viewerRef"
                            :current-stage="currentStage"
                            :model-url="content.model_url || ''"
                            @stage-change="(s) => currentStage = s"
                        />
                    </div>

                    <!-- Construction Story Timeline / Interactive Stage Navigator -->
                    <div class="bg-slate-900/60 backdrop-blur border border-slate-800/80 rounded-2xl p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-3 px-1">
                            <span class="text-[9px] font-mono uppercase tracking-[0.25em] text-slate-400">
                                CONSTRUCTION PROGRESSION TIMELINE
                            </span>
                            <span class="text-[9px] font-mono text-amber-400">
                                STAGE {{ currentStage }} OF 4
                            </span>
                        </div>

                        <!-- 4 Step Progression Stepper -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <button
                                v-for="stg in stages"
                                :key="stg.id"
                                @click="setStage(stg.id)"
                                :class="[
                                    'text-left p-3 rounded-xl border transition-all duration-300 flex flex-col justify-between relative overflow-hidden',
                                    currentStage === stg.id 
                                        ? 'bg-amber-400/10 border-amber-400/60 shadow-lg shadow-amber-400/5' 
                                        : currentStage > stg.id
                                            ? 'bg-slate-950/40 border-slate-700/60 text-slate-300 hover:border-slate-600'
                                            : 'bg-slate-950/20 border-slate-800/40 text-slate-500 hover:border-slate-700'
                                ]"
                            >
                                <div class="flex items-center justify-between w-full mb-1">
                                    <span :class="[
                                        'text-[10px] font-mono font-bold uppercase tracking-wider',
                                        currentStage === stg.id ? 'text-amber-400' : 'text-slate-400'
                                    ]">
                                        {{ stg.label }}
                                    </span>
                                    <span v-if="currentStage >= stg.id" class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                </div>
                                <span class="text-[9px] text-slate-400 font-medium">
                                    {{ stg.sub }}
                                </span>

                                <!-- Active indicator line -->
                                <div 
                                    v-if="currentStage === stg.id" 
                                    class="absolute bottom-0 left-0 right-0 h-[2px] bg-amber-400"
                                ></div>
                            </button>
                        </div>

                        <div class="mt-3 pt-3 border-t border-slate-800/60 flex items-center justify-between text-[9px] font-mono text-slate-500">
                            <span>Planning → Construction → Progress → Delivery</span>
                            <span class="italic text-slate-400">Drag or move mouse across scene to explore perspective</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<style scoped>
/* Minimal Architectural Refinements */
</style>
