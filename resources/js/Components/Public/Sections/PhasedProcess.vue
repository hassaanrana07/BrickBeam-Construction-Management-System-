<script setup>
const processes = [
    {
        step: '01',
        title: 'Plan & Baseline',
        description: 'Upload architectural models, configure work breakdown structures, and establish strict cost and critical-path baselines.'
    },
    {
        step: '02',
        title: 'Field Ticketing',
        description: 'Dispatch daily digital checklists, track labor attendance, and enforce safety gates directly with site foremen.'
    },
    {
        step: '03',
        title: 'Inspection & Telemetry',
        description: 'Inspect progress via geo-tagged photos, drone orthomosaics, and automated Earned Value variance detection.'
    },
    {
        step: '04',
        title: 'Milestone Handover',
        description: 'Generate comprehensive owner handover dossiers, final cost reconciliations, and facility turnover packages.'
    }
];
</script>

<template>
    <section class="py-24 bg-[#111111] border-t border-[#242424] relative overflow-hidden">
        <!-- Background Grid -->
        <div class="absolute inset-0 cad-dots opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                    <span class="industrial-badge text-[#E05A1B] text-[9px]">EXECUTION METHODOLOGY</span>
                </div>
                <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                    The 4-Phase Lifecycle<span class="text-[#E05A1B]">.</span>
                </h2>
                <p class="text-[#A3A3A3] text-sm sm:text-base leading-relaxed">
                    A rigorous digital execution framework designed for institutional general contractors and developers.
                </p>
            </div>

            <!-- 4 Phased Steps -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div 
                    v-for="(item, idx) in processes" 
                    :key="idx" 
                    class="industrial-panel p-6 sm:p-8 rounded-xl flex flex-col justify-between group hover-industrial relative corner-crosshair"
                >
                    <div class="space-y-6">
                        <div class="flex items-center justify-between border-b border-[#242424] pb-4">
                            <span class="font-display text-3xl font-extrabold text-[#383838] group-hover:text-[#E05A1B] transition-colors">
                                {{ item.step }}
                            </span>
                            <span class="w-2 h-2 rounded-full bg-[#242424] group-hover:bg-[#E05A1B] transition-colors"></span>
                        </div>

                        <div>
                            <h3 class="font-display text-lg font-bold uppercase text-white group-hover:text-[#E05A1B] transition-colors mb-2">
                                {{ item.title }}
                            </h3>
                            <p class="text-[#A3A3A3] text-xs leading-relaxed">
                                {{ item.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Track -->
                    <div class="pt-6 mt-6 border-t border-[#242424] flex items-center justify-between text-[10px] font-mono text-[#525252]">
                        <span>PHASE STATUS</span>
                        <span class="text-[#E05A1B]">ACTIVE</span>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>
