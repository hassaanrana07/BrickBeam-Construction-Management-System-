<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    service: Object,
    related_services: Array
});

const resolveImage = (path) => {
    if (!path) return 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070';
    if (typeof path !== 'string') return 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070';
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

// Fallback features if empty
const defaultFeatures = computed(() => [
    'Automated critical path timeline modeling and delay warning alerts',
    'Real-time on-site verification with geo-tagged photo proof submissions',
    'Multi-tier role based permissions for Owners, General Contractors, and Subs',
    'Earned Value Analysis tracking Cost Performance Index (CPI) and Schedule Performance (SPI)'
]);

const defaultBenefits = computed(() => [
    { title: '40% Faster Approvals', desc: 'Accelerate RFIs, submittals, and blueprint revision cycles across all trades.' },
    { title: 'Zero Budget Overruns', desc: 'Continuous Earned Value monitoring flags cost spikes before invoices are cleared.' },
    { title: '100% Audit Compliance', desc: 'Every task sign-off and safety inspection is permanently logged in tamper-evident records.' },
    { title: 'Seamless Coordination', desc: 'Keep office engineers and field foremen synced on identical drawings in real time.' }
]);

const defaultUseCases = computed(() => [
    { title: 'Commercial High-Rise Development', desc: 'Coordinate 30+ specialty trades, tower crane sequencing, and slipform core concrete schedules.' },
    { title: 'Industrial Logistics Facilities', desc: 'Manage PEB steel erection, super-flat floor laser screeding, and MEP infrastructure.' },
    { title: 'Luxury Master Communities', desc: 'Track multi-unit villa progress, utility groundworks, and client inspection punch lists.' }
]);
</script>

<template>
    <PublicLayout :key="$page.url">
        <Head :title="`${service.title} — BrickBeam Capabilities`" />

        <!-- 1. HERO SECTION -->
        <div class="relative pt-36 pb-24 lg:pt-48 lg:pb-32 bg-[#050811] text-white overflow-hidden border-b border-white/[0.08]">
            <!-- Background Image with dark architectural overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    :src="resolveImage(service.featured_image)" 
                    @error="($event) => $event.target.src = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070'"
                    :alt="service.title"
                    class="w-full h-full object-cover object-center filter brightness-[0.22] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#050811] via-[#050811]/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#050811]/95 via-[#581c87]/30 to-transparent"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="max-w-3xl space-y-6">
                    <Link 
                        :href="route('services')" 
                        class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.25em] text-purple-300 hover:text-orange-400 transition-colors"
                    >
                        <span>← Back to Capabilities Matrix</span>
                    </Link>

                    <div class="space-y-3">
                        <span class="text-xs font-black uppercase tracking-[0.3em] text-orange-400 block">
                            {{ service.structural_type || 'Core Construction Capability' }}
                        </span>
                        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.08] text-white">
                            {{ service.title }}<span class="text-orange-500">.</span>
                        </h1>
                    </div>

                    <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-normal">
                        {{ service.short_description }}
                    </p>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <Link 
                            :href="route('contact')"
                            class="px-8 py-4 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs rounded-xl shadow-xl shadow-orange-500/25 transition-all duration-300"
                        >
                            Request Capability Demo
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. SERVICE OVERVIEW & KEY BENEFITS -->
        <section class="py-24 lg:py-32 bg-[#070a12] text-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">
                
                <!-- Narrative Overview -->
                <div class="max-w-4xl mx-auto text-center space-y-6">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-400">Operational Overview</span>
                    <div class="text-slate-300 text-lg sm:text-xl leading-relaxed space-y-6" v-html="service.description"></div>
                </div>

                <!-- Key Benefits Grid -->
                <div class="space-y-12">
                    <div class="text-center space-y-2">
                        <h3 class="text-2xl sm:text-4xl font-black uppercase tracking-tight text-white">
                            Key Strategic Benefits<span class="text-orange-500">.</span>
                        </h3>
                        <p class="text-slate-400 text-sm">Measurable impact on jobsite performance and fiscal discipline.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div 
                            v-for="(benefit, idx) in defaultBenefits" 
                            :key="idx"
                            class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-4 hover:border-orange-500/40 transition-all duration-300"
                        >
                            <span class="text-orange-500 text-2xl font-black">0{{ idx + 1 }}</span>
                            <h4 class="text-lg font-black uppercase tracking-tight text-white">{{ benefit.title }}</h4>
                            <p class="text-slate-400 text-sm leading-relaxed">{{ benefit.desc }}</p>
                        </div>
                    </div>
                </div>

                <!-- Technical Specification Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start pt-12 border-t border-white/[0.08]">
                    
                    <!-- Left Column: Applications & Features -->
                    <div class="space-y-16">
                        <!-- Tools & Technology -->
                        <div class="space-y-6">
                            <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-400 border-l-2 border-orange-500 pl-4">Integrated Tool Ecosystem</h3>
                            <div class="flex flex-wrap gap-2.5">
                                <span 
                                    v-for="tool in (service.capability_tools?.length ? service.capability_tools : ['Procore Sync', 'Revit BIM 360', 'Primavera P6', 'DroneDeploy', 'AutoCAD Civil 3D', 'PowerBI Analytics'])" 
                                    :key="tool" 
                                    class="px-4 py-2 bg-[#0a0f1d] text-slate-200 text-xs font-bold uppercase tracking-wider rounded-xl border border-white/10"
                                >
                                    {{ tool }}
                                </span>
                            </div>
                        </div>

                        <!-- Service Features List -->
                        <div class="space-y-6">
                            <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-400 border-l-2 border-orange-500 pl-4">Core Specifications</h3>
                            <ul class="space-y-4">
                                <li 
                                    v-for="(feat, i) in (service.capability_features?.length ? service.capability_features : defaultFeatures)" 
                                    :key="i" 
                                    class="flex items-start gap-4 p-4 bg-[#0a0f1d] border border-white/[0.06] rounded-2xl"
                                >
                                    <span class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></span>
                                    <span class="text-sm font-medium text-slate-300 leading-snug">{{ feat }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Column: Deliverables & Operational Module -->
                    <div class="space-y-16">
                        <!-- Deliverables Matrix -->
                        <div class="space-y-6">
                            <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-400 border-l-2 border-orange-500 pl-4">Deliverables Matrix</h3>
                            <div class="grid grid-cols-1 gap-3">
                                <div 
                                    v-for="(del, i) in (service.capability_deliverables?.length ? service.capability_deliverables : [
                                        'Comprehensive Project Execution Plan (PEP)',
                                        'Integrated 4D BIM Construction Schedule',
                                        'Earned Value Financial & Cost Breakdown Structure',
                                        'Automated Weekly Milestone Audit Dossier'
                                    ])" 
                                    :key="i" 
                                    class="p-4 bg-[#0a0f1d] border border-white/[0.08] text-xs font-bold uppercase tracking-wider text-slate-300 rounded-xl flex items-center justify-between"
                                >
                                    <span>{{ del }}</span>
                                    <span class="text-orange-500 font-bold">✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Operational Execution Card -->
                        <div class="p-8 sm:p-10 bg-gradient-to-br from-[#0a0f1d] to-[#0e162e] border border-white/10 rounded-3xl space-y-6 relative overflow-hidden shadow-2xl">
                            <div class="absolute -top-12 -right-12 w-32 h-32 bg-orange-500/10 rounded-full blur-2xl"></div>
                            
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-400 block">Operational Governance</span>
                            <h4 class="text-xl font-black uppercase text-white tracking-tight">Deployment & Execution Squad</h4>
                            <p class="text-sm text-slate-300 leading-relaxed">
                                {{ service.operations_description || 'Multi-tiered operational control overseeing daily site logs, material intake validation, inspection sign-offs, and critical path adjustments.' }}
                            </p>

                            <div class="grid grid-cols-2 gap-6 pt-4 border-t border-white/10">
                                <div>
                                    <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Timeline Scope</span>
                                    <span class="text-xs font-black uppercase text-orange-400 tracking-wider">{{ service.operations_timeline || 'Full Lifecycle' }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Assigned Unit</span>
                                    <span class="text-xs font-black uppercase text-white tracking-wider">{{ service.operations_team || 'PMO Taskforce' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3. HOW IT WORKS / PHASED DEPLOYMENT -->
                <div class="pt-24 border-t border-white/[0.08] space-y-16">
                    <div class="text-center space-y-3">
                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-400">Execution Lifecycle</span>
                        <h3 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">How It Works<span class="text-orange-500">.</span></h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div 
                            v-for="(phase, idx) in (service.phases_details?.length ? service.phases_details : [
                                { title: '1. Baseline Ingestion', description: 'Linking drawings, schedule CPM, and BOQ into the centralized repository.' },
                                { title: '2. Field Dispatching', description: 'Allocating daily trade tasks with digital checklists and safety sign-offs.' },
                                { title: '3. Telemetry Verification', description: 'Verifying physical progress with drone orthomosaics and 360 virtual tours.' },
                                { title: '4. Executive Auditing', description: 'Delivering real-time Earned Value reporting and milestone certificates.' }
                            ])" 
                            :key="idx"
                            class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-4 hover:border-orange-500/50 transition-all duration-300 flex flex-col justify-between"
                        >
                            <div class="w-12 h-12 rounded-2xl bg-orange-500/10 border border-orange-500/30 flex items-center justify-center text-orange-400 font-black text-lg">
                                0{{ idx + 1 }}
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-base font-black uppercase tracking-tight text-white">{{ phase.title }}</h4>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">{{ phase.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. REALISTIC USE CASES -->
                <div class="pt-24 border-t border-white/[0.08] space-y-12">
                    <div class="text-center space-y-2">
                        <h3 class="text-2xl sm:text-4xl font-black uppercase tracking-tight text-white">
                            Industry Use Cases<span class="text-orange-500">.</span>
                        </h3>
                        <p class="text-slate-400 text-sm">Where this capability delivers highest ROI across diverse construction environments.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div 
                            v-for="(uc, idx) in defaultUseCases" 
                            :key="idx"
                            class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-3"
                        >
                            <h4 class="text-base font-black uppercase tracking-tight text-orange-400">{{ uc.title }}</h4>
                            <p class="text-slate-300 text-sm leading-relaxed">{{ uc.desc }}</p>
                        </div>
                    </div>
                </div>

                <!-- 5. RELATED SERVICES -->
                <div v-if="related_services && related_services.length" class="pt-20 border-t border-white/[0.08]">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-slate-400 mb-8 text-center">Interlinked Capabilities</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <Link 
                            v-for="related in related_services" 
                            :key="related.id" 
                            :href="route('services.show', related.slug)" 
                            class="p-6 bg-[#0a0f1d] border border-white/[0.08] hover:border-orange-500 rounded-2xl transition-all flex justify-between items-center group"
                        >
                            <span class="text-xs font-black uppercase tracking-wider text-slate-300 group-hover:text-white transition-colors">{{ related.title }}</span>
                            <span class="text-orange-500 group-hover:translate-x-1 transition-transform">→</span>
                        </Link>
                    </div>
                </div>

                <!-- 6. CONVERSION CTA -->
                <div class="text-center space-y-8 bg-gradient-to-br from-[#0a0f1d] to-[#070a12] p-12 sm:p-20 rounded-3xl border border-white/10 shadow-2xl relative overflow-hidden">
                    <div class="space-y-3 relative z-10">
                        <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                            Ready to Deploy {{ service.title }}?
                        </h2>
                        <p class="text-slate-400 text-sm max-w-xl mx-auto">
                            Consult with our solutions engineers to integrate this module into your active project portfolio.
                        </p>
                    </div>
                    <Link 
                        :href="route('contact')" 
                        class="inline-block px-10 py-5 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs rounded-xl shadow-2xl shadow-orange-500/30 transition-all duration-300 relative z-10"
                    >
                        Schedule Project Consultation
                    </Link>
                </div>

            </div>
        </section>

    </PublicLayout>
</template>
