<script setup>
import { ref } from 'vue';

const activeTab = ref('projects');

const projects = [
    { name: 'Skyline Residence (Sector F-7)', type: 'Luxury High-Rise', progress: 92, status: 'In Progress', budget: 'PKR 85M', cpi: '1.04 (Under Budget)' },
    { name: 'Urban Business Tower (Clifton)', type: 'Commercial Complex', progress: 76, status: 'In Progress', budget: 'PKR 140M', cpi: '0.99 (On Target)' },
    { name: 'Riverside Eco-Villas (Rawalpindi)', type: 'Master Community', progress: 100, status: 'Completed', budget: 'PKR 65M', cpi: '1.08 (Reconciled)' },
    { name: 'Metro Commerce Hub (Gulberg III)', type: 'Twin Tower Complex', progress: 45, status: 'In Progress', budget: 'PKR 220M', cpi: '1.01 (On Target)' }
];

const activityLogs = [
    { time: '10:42 AM', user: 'Engr. Tariq (Site Lead)', action: 'Logged geo-tagged pour inspection at Floor 14 slab', project: 'Skyline Residence', tag: 'Inspection' },
    { time: '09:15 AM', user: 'Super Admin', action: 'Approved Purchase Order PO-8821 for high-tensile rebar', project: 'Urban Business Tower', tag: 'Finance' },
    { time: '08:30 AM', user: 'Safety Officer', action: 'Completed daily OSHA jobsite audit — Zero incidents', project: 'Metro Commerce Hub', tag: 'Safety' },
    { time: 'Yesterday', user: 'Finance Manager', action: 'Reconciled final subcontractor retention release', project: 'Riverside Eco-Villas', tag: 'Handover' }
];

const trades = [
    { trade: 'Structural Civil Engineering', lead: 'Matrix Engineering Ltd', workers: 64, compliance: '100% OSHA' },
    { trade: 'MEP & HVAC Systems', lead: 'Apex Climatic Solutions', workers: 28, compliance: '98% OSHA' },
    { trade: 'Facade Curtain Wall Glass', lead: 'Visionary Glassworks', workers: 19, compliance: '100% OSHA' },
    { trade: 'Internal Architectural Finishes', lead: 'Artisan Fitouts PK', workers: 35, compliance: '96% OSHA' }
];
</script>

<template>
    <section class="py-24 bg-[#0D0D0D] border-t border-[#242424] relative overflow-hidden">
        <!-- Background Grid -->
        <div class="absolute inset-0 cad-grid opacity-25 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                    <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                    <span class="industrial-badge text-[#E05A1B] text-[9px]">LIVE INTERFACE TELEMETRY</span>
                </div>
                <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                    The BrickBeam Command Center<span class="text-[#E05A1B]">.</span>
                </h2>
                <p class="text-[#A3A3A3] text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                    Designed for high information density, instant decision-making, and zero friction across leadership and jobsites.
                </p>
            </div>

            <!-- Command Center Frame -->
            <div class="industrial-panel-elevated rounded-2xl overflow-hidden shadow-2xl border border-[#242424]">
                
                <!-- OS-Style Browser / Window Bar -->
                <div class="bg-[#141414] px-5 py-3.5 border-b border-[#242424] flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#383838]"></span>
                        <span class="w-3 h-3 rounded-full bg-[#383838]"></span>
                        <span class="w-3 h-3 rounded-full bg-[#383838]"></span>
                        <span class="ml-3 font-mono text-[10px] text-[#A3A3A3]">BRICKBEAM CORE // PRODUCTION ENVIRONMENT // EVM TELEMETRY</span>
                    </div>

                    <!-- Interactive Module Tabs -->
                    <div class="flex items-center gap-1 bg-[#0D0D0D] p-1 rounded-lg border border-[#242424]">
                        <button 
                            @click="activeTab = 'projects'"
                            class="px-3 py-1 rounded text-xs font-display font-semibold uppercase tracking-wider transition-all"
                            :class="activeTab === 'projects' ? 'bg-[#242424] text-white' : 'text-[#A3A3A3] hover:text-white'"
                        >
                            Active Sites
                        </button>
                        <button 
                            @click="activeTab = 'activity'"
                            class="px-3 py-1 rounded text-xs font-display font-semibold uppercase tracking-wider transition-all"
                            :class="activeTab === 'activity' ? 'bg-[#242424] text-white' : 'text-[#A3A3A3] hover:text-white'"
                        >
                            Jobsite Logs
                        </button>
                        <button 
                            @click="activeTab = 'trades'"
                            class="px-3 py-1 rounded text-xs font-display font-semibold uppercase tracking-wider transition-all"
                            :class="activeTab === 'trades' ? 'bg-[#242424] text-white' : 'text-[#A3A3A3] hover:text-white'"
                        >
                            Trade Matrix
                        </button>
                    </div>
                </div>

                <!-- Main Application Display Workspace -->
                <div class="p-6 sm:p-8 bg-[#171717]">
                    
                    <!-- Top EVM KPI Bar -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="p-4 bg-[#111111] border border-[#242424] rounded-xl">
                            <span class="industrial-badge text-[9px] text-[#525252] block mb-1">TOTAL COMMITTED CAPITAL</span>
                            <div class="font-display text-2xl font-bold text-white">PKR 510M</div>
                            <span class="text-[10px] text-[#E5A93C] font-mono mt-1 block">4 Major Sites Active</span>
                        </div>
                        <div class="p-4 bg-[#111111] border border-[#242424] rounded-xl">
                            <span class="industrial-badge text-[9px] text-[#525252] block mb-1">COST PERFORMANCE (CPI)</span>
                            <div class="font-display text-2xl font-bold text-[#E05A1B]">1.03 CPI</div>
                            <span class="text-[10px] text-green-400 font-mono mt-1 block">+3% Favorable Variance</span>
                        </div>
                        <div class="p-4 bg-[#111111] border border-[#242424] rounded-xl">
                            <span class="industrial-badge text-[9px] text-[#525252] block mb-1">SCHEDULE ADHERENCE (SPI)</span>
                            <div class="font-display text-2xl font-bold text-white">0.99 SPI</div>
                            <span class="text-[10px] text-[#A3A3A3] font-mono mt-1 block">On-Time Critical Path</span>
                        </div>
                        <div class="p-4 bg-[#111111] border border-[#242424] rounded-xl">
                            <span class="industrial-badge text-[9px] text-[#525252] block mb-1">DEPLOYED LABOR FORCE</span>
                            <div class="font-display text-2xl font-bold text-white">146 Active</div>
                            <span class="text-[10px] text-[#E5A93C] font-mono mt-1 block">100% OSHA Compliant</span>
                        </div>
                    </div>

                    <!-- TAB 1: Active Projects Matrix -->
                    <div v-if="activeTab === 'projects'" class="space-y-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-[#242424] text-[10px] font-mono text-[#525252] uppercase">
                                        <th class="pb-3 px-3">Project Title</th>
                                        <th class="pb-3 px-3">Sector</th>
                                        <th class="pb-3 px-3">Budget</th>
                                        <th class="pb-3 px-3">EVM Status</th>
                                        <th class="pb-3 px-3">Milestone Progress</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#242424] text-xs">
                                    <tr v-for="(item, i) in projects" :key="i" class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 px-3 font-display font-bold text-white flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full" :class="item.status === 'Completed' ? 'bg-green-400' : 'bg-[#E05A1B]'"></span>
                                            {{ item.name }}
                                        </td>
                                        <td class="py-4 px-3 text-[#A3A3A3]">{{ item.type }}</td>
                                        <td class="py-4 px-3 font-mono font-bold text-white">{{ item.budget }}</td>
                                        <td class="py-4 px-3">
                                            <span class="px-2.5 py-1 bg-[#111111] border border-[#242424] text-[10px] font-mono text-[#E5A93C] rounded">
                                                {{ item.cpi }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-3 min-w-[140px]">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-1 h-1.5 bg-[#242424] rounded-full overflow-hidden">
                                                    <div 
                                                        class="h-full bg-gradient-to-r from-[#E05A1B] to-[#E5A93C] rounded-full" 
                                                        :style="{ width: `${item.progress}%` }"
                                                    ></div>
                                                </div>
                                                <span class="font-mono text-[10px] text-white font-bold">{{ item.progress }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB 2: Real-Time Jobsite Telemetry Logs -->
                    <div v-if="activeTab === 'activity'" class="space-y-3">
                        <div 
                            v-for="(log, idx) in activityLogs" 
                            :key="idx"
                            class="p-4 bg-[#111111] border border-[#242424] rounded-xl flex flex-wrap items-center justify-between gap-4"
                        >
                            <div class="flex items-center gap-4">
                                <span class="font-mono text-[10px] text-[#525252]">{{ log.time }}</span>
                                <div>
                                    <h4 class="font-display text-xs font-bold text-white">{{ log.user }}</h4>
                                    <p class="text-xs text-[#A3A3A3]">{{ log.action }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="industrial-badge text-[9px] text-[#E05A1B] bg-[#E05A1B]/10 px-2 py-1 rounded border border-[#E05A1B]/20">
                                    {{ log.tag }}
                                </span>
                                <span class="font-mono text-[10px] text-[#A3A3A3]">{{ log.project }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: Subcontractor Trade Matrix -->
                    <div v-if="activeTab === 'trades'" class="space-y-3">
                        <div 
                            v-for="(t, idx) in trades" 
                            :key="idx"
                            class="p-4 bg-[#111111] border border-[#242424] rounded-xl flex flex-wrap items-center justify-between gap-4"
                        >
                            <div>
                                <h4 class="font-display text-xs font-bold text-white uppercase">{{ t.trade }}</h4>
                                <p class="text-xs text-[#A3A3A3] mt-0.5">Contractor Partner: {{ t.lead }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <span class="industrial-badge text-[8px] text-[#525252] block">FIELD DEPLOYMENT</span>
                                    <span class="font-mono text-xs font-bold text-white">{{ t.workers }} Active Tradesmen</span>
                                </div>
                                <span class="px-2.5 py-1 bg-[#171717] border border-[#242424] text-[10px] font-mono text-green-400 rounded">
                                    {{ t.compliance }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
</template>
