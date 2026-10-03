<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    service: Object,
    related_services: Array
});

const defaultImg = 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070';

const resolveImage = (path) => {
    if (!path) return defaultImg;
    if (typeof path !== 'string') return defaultImg;
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

// Fallback features if empty
const defaultFeatures = computed(() => [
    'Automated critical path timeline modeling and predictive delay warning telemetry',
    'Real-time on-site verification with geo-tagged photographic inspection logs',
    'Multi-tier role-based permissions for Owners, General Contractors, and Specialty Trades',
    'Earned Value Analysis tracking Cost Performance Index (CPI) and Schedule Performance Index (SPI)'
]);

const defaultBenefits = computed(() => [
    { title: '40% Faster Approvals', desc: 'Accelerate RFIs, submittals, and architectural revision cycles across all active trades.' },
    { title: 'Zero Budget Overruns', desc: 'Continuous Earned Value monitoring flags cost spikes before purchase orders are cleared.' },
    { title: '100% Audit Compliance', desc: 'Every task sign-off and safety inspection is permanently logged in tamper-evident records.' },
    { title: 'Seamless Jobsite Sync', desc: 'Keep office engineers and field foremen synchronized on identical BIM drawings in real time.' }
]);

const defaultUseCases = computed(() => [
    { title: 'Commercial High-Rise Development', desc: 'Coordinate 30+ specialty trades, tower crane sequencing, and slipform core concrete schedules.' },
    { title: 'Industrial Logistics Facilities', desc: 'Manage PEB steel erection, super-flat floor laser screeding, and MEP infrastructure.' },
    { title: 'Luxury Bespoke Estates', desc: 'Track multi-unit residential progress, subterranean micropiling, and client punch lists.' }
]);
</script>

<template>
    <PublicLayout :key="$page.url">
        <Head :title="`${service.title} — BrickBeam Capabilities`" />

        <!-- 1. HERO SECTION -->
        <div class="relative pt-36 pb-20 lg:pt-44 lg:pb-28 bg-[#0D0D0D] text-white overflow-hidden border-b border-[#242424]">
            <!-- Background Image with dark architectural overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    :src="resolveImage(service.featured_image)" 
                    @error="($event) => $event.target.src = defaultImg"
                    :alt="service.title"
                    class="w-full h-full object-cover object-center filter brightness-[0.25] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-[#0D0D0D]/80 to-transparent"></div>
                <div class="absolute inset-0 cad-grid opacity-20 pointer-events-none"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="max-w-3xl space-y-6">
                    <Link 
                        :href="route('services')" 
                        class="inline-flex items-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-[#E05A1B] transition-colors"
                    >
                        <span>← Back to Capabilities Matrix</span>
                    </Link>

                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                            <span class="industrial-badge text-[#E05A1B] text-[9px]">
                                {{ service.structural_type || 'CORE SYSTEM CAPABILITY' }}
                            </span>
                        </div>
                        <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.04] text-white">
                            {{ service.title }}<span class="text-[#E05A1B]">.</span>
                        </h1>
                    </div>

                    <p class="text-base sm:text-lg text-[#A3A3A3] leading-relaxed font-normal">
                        {{ service.short_description }}
                    </p>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <Link 
                            :href="route('contact')"
                            class="px-7 py-3.5 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs rounded-xl shadow-lg shadow-[#E05A1B]/20 transition-all duration-300"
                        >
                            Request Technical Demo
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. SERVICE OVERVIEW & KEY BENEFITS -->
        <section class="py-24 bg-[#111111] text-white relative border-b border-[#242424]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
                
                <!-- Narrative Overview -->
                <div class="max-w-4xl mx-auto text-center space-y-4">
                    <span class="industrial-badge text-[#E05A1B] text-[9px]">OPERATIONAL OVERVIEW</span>
                    <div class="text-[#A3A3A3] text-base sm:text-lg leading-relaxed space-y-4" v-html="service.description"></div>
                </div>

                <!-- Key Benefits Grid -->
                <div class="space-y-10">
                    <div class="text-center space-y-2">
                        <h3 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-white">
                            Strategic Engineering Impact<span class="text-[#E05A1B]">.</span>
                        </h3>
                        <p class="text-[#A3A3A3] text-xs sm:text-sm">Measurable performance on jobsite scheduling and fiscal discipline.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div 
                            v-for="(benefit, idx) in defaultBenefits" 
                            :key="idx"
                            class="industrial-panel p-8 rounded-2xl space-y-4 bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/50 transition-all duration-300 shadow-xl corner-crosshair"
                        >
                            <span class="font-display text-2xl font-extrabold text-[#E05A1B]">0{{ idx + 1 }}</span>
                            <h4 class="font-display text-base font-bold uppercase tracking-tight text-white">{{ benefit.title }}</h4>
                            <p class="text-[#A3A3A3] text-xs leading-relaxed">{{ benefit.desc }}</p>
                        </div>
                    </div>
                </div>

                <!-- Technical Specification Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start pt-12 border-t border-[#242424]">
                    
                    <!-- Left Column: Ecosystem & Features -->
                    <div class="space-y-12">
                        <!-- Tools & Technology -->
                        <div class="space-y-4">
                            <span class="industrial-badge text-[#E05A1B] text-[9px] block">INTEGRATED TOOL ECOSYSTEM</span>
                            <div class="flex flex-wrap gap-2">
                                <span 
                                    v-for="tool in (service.capability_tools?.length ? service.capability_tools : ['Autodesk Revit BIM', 'Procore Telemetry', 'Primavera P6 Gantt', 'Trimble Total Station', 'AutoCAD Civil 3D', 'SAP2000 FEA'])" 
                                    :key="tool" 
                                    class="industrial-badge px-3 py-1.5 bg-[#171717] text-[#F3F1EC] text-[10px] rounded-lg border border-[#242424]"
                                >
                                    {{ tool }}
                                </span>
                            </div>
                        </div>

                        <!-- Service Features List -->
                        <div class="space-y-4">
                            <span class="industrial-badge text-[#E05A1B] text-[9px] block">CORE SPECIFICATIONS</span>
                            <ul class="space-y-3">
                                <li 
                                    v-for="(feat, i) in (service.capability_features?.length ? service.capability_features : defaultFeatures)" 
                                    :key="i" 
                                    class="flex items-start gap-3 p-4 bg-[#171717] border border-[#242424] rounded-xl text-xs text-[#A3A3A3]"
                                >
                                    <span class="w-1.5 h-1.5 bg-[#E05A1B] rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span>{{ feat }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Column: Deliverables & Squad Governance -->
                    <div class="space-y-12">
                        <!-- Deliverables Matrix -->
                        <div class="space-y-4">
                            <span class="industrial-badge text-[#E05A1B] text-[9px] block">DELIVERABLES DOSSIER</span>
                            <div class="grid grid-cols-1 gap-2.5">
                                <div 
                                    v-for="(del, i) in (service.capability_deliverables?.length ? service.capability_deliverables : [
                                        'Comprehensive Project Execution Plan (PEP)',
                                        'Integrated 4D BIM Construction Schedule',
                                        'Earned Value Financial & Cost Breakdown Structure',
                                        'Automated Weekly Milestone Audit Dossier'
                                    ])" 
                                    :key="i" 
                                    class="p-4 bg-[#171717] border border-[#242424] text-xs font-display font-bold uppercase tracking-wider text-[#F3F1EC] rounded-xl flex items-center justify-between"
                                >
                                    <span>{{ del }}</span>
                                    <span class="text-[#E05A1B] font-mono">✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Operational Execution Card -->
                        <div class="p-8 bg-[#171717] border border-[#242424] rounded-2xl space-y-5 shadow-2xl relative overflow-hidden corner-crosshair">
                            <span class="industrial-badge text-[#E05A1B] text-[9px] block">OPERATIONAL GOVERNANCE</span>
                            <h4 class="font-display text-lg font-bold uppercase text-white tracking-tight">Deployment & Execution Squad</h4>
                            <p class="text-xs text-[#A3A3A3] leading-relaxed">
                                {{ service.operations_description || 'Multi-tiered operational control overseeing daily site logs, material intake validation, inspection sign-offs, and critical path adjustments.' }}
                            </p>

                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-[#242424]">
                                <div>
                                    <span class="industrial-badge text-[8px] text-[#525252] block mb-1">TIMELINE SCOPE</span>
                                    <span class="font-display text-xs font-bold text-[#E5A93C] uppercase">{{ service.operations_timeline || 'Full Lifecycle' }}</span>
                                </div>
                                <div>
                                    <span class="industrial-badge text-[8px] text-[#525252] block mb-1">ASSIGNED UNIT</span>
                                    <span class="font-display text-xs font-bold text-white uppercase">{{ service.operations_team || 'PMO Taskforce' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3. REALISTIC USE CASES -->
                <div class="pt-16 border-t border-[#242424] space-y-8">
                    <div class="text-center space-y-2">
                        <h3 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-white">
                            Industry Deployment Profiles<span class="text-[#E05A1B]">.</span>
                        </h3>
                        <p class="text-[#A3A3A3] text-xs sm:text-sm">High-value execution across institutional construction categories.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div 
                            v-for="(uc, idx) in defaultUseCases" 
                            :key="idx" 
                            class="industrial-panel p-6 sm:p-8 bg-[#171717] border border-[#242424] rounded-xl space-y-2"
                        >
                            <h4 class="font-display text-sm font-bold uppercase tracking-wider text-[#E05A1B]">{{ uc.title }}</h4>
                            <p class="text-[#A3A3A3] text-xs leading-relaxed">{{ uc.desc }}</p>
                        </div>
                    </div>
                </div>

                <!-- 4. RELATED SERVICES -->
                <div v-if="related_services && related_services.length" class="pt-12 border-t border-[#242424]">
                    <h3 class="industrial-badge text-[#A3A3A3] text-center text-[10px] mb-6">INTERLINKED CAPABILITIES</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <Link 
                            v-for="related in related_services" 
                            :key="related.id" 
                            :href="route('services.show', related.slug)" 
                            class="p-5 bg-[#171717] border border-[#242424] hover:border-[#E05A1B] rounded-xl transition-all flex justify-between items-center group"
                        >
                            <span class="text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] group-hover:text-white transition-colors">{{ related.title }}</span>
                            <span class="text-[#E05A1B] group-hover:translate-x-1 transition-transform">→</span>
                        </Link>
                    </div>
                </div>

                <!-- 5. CONVERSION CTA -->
                <div class="text-center space-y-6 bg-[#171717] p-10 sm:p-16 rounded-2xl border border-[#242424] shadow-2xl relative overflow-hidden corner-crosshair">
                    <div class="space-y-3 relative z-10">
                        <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-white">
                            Ready to Deploy {{ service.title }}?
                        </h2>
                        <p class="text-[#A3A3A3] text-xs sm:text-sm max-w-xl mx-auto">
                            Consult with our senior solutions engineers to integrate this module into your active project portfolio.
                        </p>
                    </div>
                    <Link 
                        :href="route('contact')" 
                        class="inline-block px-8 py-4 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs rounded-xl shadow-lg shadow-[#E05A1B]/20 transition-all duration-300 relative z-10"
                    >
                        Schedule Technical Consultation
                    </Link>
                </div>

            </div>
        </section>

    </PublicLayout>
</template>
