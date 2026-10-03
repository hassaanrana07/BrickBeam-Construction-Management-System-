<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    services: {
        type: Array,
        default: () => []
    }
});

const defaultServices = [
    {
        title: 'Project Command & Scheduling',
        slug: 'project-management',
        short_description: 'Establish work breakdown structures, critical path timelines, and synchronized BIM/CAD document controls.',
        icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'
    },
    {
        title: 'Task & Daily Defect Ticketing',
        slug: 'task-management',
        short_description: 'Assign geo-located checklists, inspect photo verification logs, and eliminate schedule bottlenecks.',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'
    },
    {
        title: 'Trade & Labor Allocation',
        slug: 'team-management',
        short_description: 'Coordinate specialty trades, monitor OSHA safety certifications, and track workforce headcount across sites.',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'
    },
    {
        title: 'Earned Value & Budget Control',
        slug: 'budget-management',
        short_description: 'Real-time Cost Performance Index (CPI), automated purchase order matching, and cashflow projection.',
        icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    },
    {
        title: 'Jobsite Milestone Telemetry',
        slug: 'progress-tracking',
        short_description: 'Track physical milestone percentages against engineering baselines with automated delay forecast alerts.',
        icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'
    },
    {
        title: 'Executive Analytics & Dossiers',
        slug: 'reports-analytics',
        short_description: 'Export tamper-evident stakeholder reports, financial variance dossiers, and owner turnover documentation.',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
    }
];

const activeServices = computed(() => {
    return (props.services && props.services.length >= 4) ? props.services : defaultServices;
});
</script>

<template>
    <section id="capabilities-section" class="py-24 bg-[#111111] border-t border-[#242424] relative overflow-hidden">
        <!-- Subtle CAD Dots -->
        <div class="absolute inset-0 cad-dots opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6 border-b border-[#242424] pb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-3">
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">CAPABILITIES MATRIX</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                        Core System Modules<span class="text-[#E05A1B]">.</span>
                    </h2>
                </div>

                <Link 
                    :href="route('services')"
                    class="inline-flex items-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-[#E05A1B] transition-colors"
                >
                    <span>View All Capabilities</span>
                    <span>→</span>
                </Link>
            </div>

            <!-- 6 Grid Modules -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <Link 
                    v-for="(service, idx) in activeServices.slice(0, 6)" 
                    :key="service.id || idx"
                    :href="route('services.show', service.slug || 'project-management')"
                    class="industrial-panel p-8 rounded-xl hover-industrial flex flex-col justify-between group relative overflow-hidden shadow-xl corner-crosshair"
                >
                    <div>
                        <!-- Top Metadata Strip -->
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#242424]">
                            <span class="industrial-badge text-[#525252] group-hover:text-[#E05A1B] transition-colors">
                                MODULE 0{{ idx + 1 }}
                            </span>
                            <div class="w-9 h-9 rounded-lg bg-[#242424] group-hover:bg-[#E05A1B] text-[#A3A3A3] group-hover:text-[#0D0D0D] flex items-center justify-center transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="service.icon || 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="font-display text-xl font-bold uppercase text-white group-hover:text-[#E05A1B] transition-colors mb-3">
                            {{ service.title }}
                        </h3>
                        <p class="text-[#A3A3A3] text-xs leading-relaxed">
                            {{ service.short_description }}
                        </p>
                    </div>

                    <!-- Bottom Link Action -->
                    <div class="pt-6 mt-6 border-t border-[#242424] flex items-center justify-between text-xs font-display font-semibold uppercase tracking-wider text-[#525252] group-hover:text-white transition-colors">
                        <span>Inspect Module Specification</span>
                        <span class="text-[#E05A1B] font-bold group-hover:translate-x-1 transition-transform">→</span>
                    </div>

                    <!-- Bottom Accent Bar -->
                    <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-[#E05A1B] group-hover:w-full transition-all duration-500"></div>
                </Link>
            </div>

        </div>
    </section>
</template>
