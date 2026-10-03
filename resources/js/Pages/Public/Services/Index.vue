<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import DevelopmentProtocol from '@/Components/Public/Sections/DevelopmentProtocol.vue';

const props = defineProps({
    services: Array,
    page: Object,
    estimation_rules: Array,
    faqs: Array
});

// ── Calculator Logic ──────────────────────────────────────────
const area = ref(2500);
const selectedRuleId = ref(props.estimation_rules?.[0]?.id || null);
const selectedSector = ref('residential');
const selectedScope = ref('standard');

const currentRule = computed(() => 
    props.estimation_rules?.find(r => r.id === selectedRuleId.value) || props.estimation_rules?.[0]
);

const scopeMultipliers = { standard: 1.0, premium: 1.25, luxury: 1.5 };

const estimation = computed(() => {
    if (!currentRule.value) {
        // Fallback default calculation if no estimation rules configured
        const baseRate = 185;
        const baseCost = area.value * baseRate;
        const scopeMult = scopeMultipliers[selectedScope.value] || 1.0;
        const sectorMult = selectedSector.value === 'commercial' ? 1.2 : (selectedSector.value === 'industrial' ? 1.35 : 1.0);
        const total = baseCost * sectorMult * scopeMult;
        return {
            total: Math.round(total),
            breakdown: [
                { label: 'Structural Concrete & Framing', amount: Math.round(total * 0.45) },
                { label: 'Architectural Enclosure & Glazing', amount: Math.round(total * 0.30) },
                { label: 'MEP Infrastructure & Commissioning', amount: Math.round(total * 0.25) },
            ],
            timeline: Math.max(8, Math.ceil((area.value / 1000) * 6 * scopeMult)),
            resources: Math.ceil(area.value / 400) + (selectedScope.value === 'luxury' ? 4 : 0)
        };
    }

    const rule = currentRule.value;
    const baseRate = rule.base_rate_per_sqft || 185;
    const matMult = (rule.material_cost_factor || 0.15);
    const labMult = (rule.labor_cost_factor || 0.10);
    const sectorMult = (rule.sector_multipliers && rule.sector_multipliers[selectedSector.value]) || 1.0;
    const scopeMult = scopeMultipliers[selectedScope.value] || 1.0;

    const baseCost = area.value * baseRate;
    const totalCost = baseCost * (1 + matMult + labMult) * sectorMult * scopeMult;
    
    const weeksPer1K = rule.timeline_weeks_per_1000sqft || 6;
    const estimatedWeeks = Math.max(6, Math.ceil((area.value / 1000) * weeksPer1K * scopeMult));

    return {
        total: Math.round(totalCost),
        breakdown: [
            { label: 'Structural Core & Subterranean', amount: Math.round(baseCost * sectorMult * scopeMult * 0.5) },
            { label: 'Materials & Finish Tolerances', amount: Math.round(baseCost * (1 + matMult) * sectorMult * scopeMult * 0.3) },
            { label: 'Specialized Labor & Telemetry', amount: Math.round(baseCost * (1 + labMult) * sectorMult * scopeMult * 0.2) },
        ],
        timeline: estimatedWeeks,
        resources: Math.ceil(area.value / 450) + (selectedScope.value === 'luxury' ? 3 : 0)
    };
});

const formatCurrency = (val) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0
    }).format(val || 0);
};

const resolveImage = (path, idx) => {
    if (!path) return 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070';
    if (typeof path !== 'string') return 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070';
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};
</script>

<template>
    <PublicLayout>
        <Head title="System Capabilities & Engineering Modules — BrickBeam" />

        <!-- 1. Architectural Header -->
        <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-24 bg-[#0D0D0D] border-b border-[#242424] overflow-hidden">
            <!-- CAD Grid Backdrop -->
            <div class="absolute inset-0 cad-grid opacity-30 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 bg-[#171717] border border-[#242424] rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                        <span class="industrial-badge text-[#A3A3A3] text-[9px] tracking-[0.25em]">
                            TECHNICAL CAPABILITIES SPECIFICATION
                        </span>
                    </div>

                    <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.04] text-white">
                        SYSTEM <span class="text-[#E05A1B]">CAPABILITIES.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-[#A3A3A3] leading-relaxed font-normal">
                        Enterprise-grade construction management modules engineered for high-density structural coordination, EVM budget control, and turnkey delivery.
                    </p>
                </div>
            </div>
        </section>

        <!-- 2. Capabilities Grid -->
        <section class="py-24 bg-[#111111] border-b border-[#242424] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                    <div 
                        v-for="(service, idx) in services" 
                        :key="service.id || idx" 
                        class="industrial-panel rounded-2xl overflow-hidden flex flex-col justify-between group shadow-xl corner-crosshair bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/50 transition-all duration-300"
                    >
                        <!-- Service Top Image -->
                        <div class="relative aspect-[16/9] overflow-hidden bg-[#0D0D0D]">
                            <img 
                                :src="resolveImage(service.featured_image, idx)" 
                                :alt="service.title"
                                class="w-full h-full object-cover filter brightness-[0.75] contrast-120 group-hover:scale-105 transition-transform duration-700 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-transparent to-transparent"></div>

                            <!-- Top Badges -->
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
                                <span class="industrial-badge px-2.5 py-1 bg-[#0D0D0D]/90 border border-[#242424] text-white rounded">
                                    MODULE 0{{ idx + 1 }}
                                </span>
                                <span class="industrial-badge px-2.5 py-1 bg-[#171717] border border-[#E05A1B]/60 text-[#E05A1B] rounded">
                                    {{ service.structural_type || 'Active Capability' }}
                                </span>
                            </div>
                        </div>

                        <!-- Service Content -->
                        <div class="p-8 space-y-5 flex-1 flex flex-col justify-between">
                            <div class="space-y-3">
                                <h2 class="font-display text-2xl font-bold uppercase text-white group-hover:text-[#E05A1B] transition-colors">
                                    {{ service.title }}
                                </h2>
                                <p class="text-[#A3A3A3] text-sm leading-relaxed">
                                    {{ service.short_description }}
                                </p>
                            </div>

                            <!-- Tools & Deliverables Tags -->
                            <div v-if="service.capability_tools && service.capability_tools.length" class="space-y-2 pt-3 border-t border-[#242424]">
                                <span class="industrial-badge text-[8px] text-[#525252] block">TOOL MATRIX</span>
                                <div class="flex flex-wrap gap-2">
                                    <span 
                                        v-for="(tool, tIdx) in service.capability_tools.slice(0, 4)" 
                                        :key="tIdx"
                                        class="industrial-badge px-2 py-0.5 bg-[#0D0D0D] border border-[#242424] text-[#A3A3A3] rounded text-[9px]"
                                    >
                                        {{ tool }}
                                    </span>
                                </div>
                            </div>

                            <!-- Footer Action -->
                            <div class="pt-6 border-t border-[#242424] flex items-center justify-between">
                                <Link 
                                    :href="route('services.show', service.slug || '')" 
                                    class="inline-flex items-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#E05A1B] group-hover:text-white transition-colors"
                                >
                                    <span>Inspect Technical Dossier</span>
                                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                                </Link>
                                <span class="font-mono text-[9px] text-[#525252]">{{ service.operations_timeline || 'Turnkey Phase' }}</span>
                            </div>
                        </div>

                        <!-- Accent bottom bar -->
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E05A1B] group-hover:w-full transition-all duration-500"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Integrated Structural Cost Calculator -->
        <section class="py-24 bg-[#0D0D0D] border-b border-[#242424] relative overflow-hidden">
            <!-- Background CAD Blueprint Grid -->
            <div class="absolute inset-0 cad-grid opacity-20 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                    
                    <!-- Left Column: Parameters Input -->
                    <div class="lg:col-span-6 space-y-8">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                                <span class="industrial-badge text-[#E05A1B] text-[9px]">ESTIMATION ENGINE</span>
                            </div>
                            <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight leading-tight">
                                Structural Cost<br/>Calculator<span class="text-[#E05A1B]">.</span>
                            </h2>
                            <p class="text-sm text-[#A3A3A3] mt-3 leading-relaxed">
                                Our real-time parametric estimation engine calculates baseline capital requirements and critical path delivery weeks based on active material logistics indices.
                            </p>
                        </div>

                        <div class="space-y-6 bg-[#171717] border border-[#242424] p-6 sm:p-8 rounded-2xl shadow-xl">
                            <!-- Area Slider -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="industrial-badge text-[9px] text-[#A3A3A3]">TOTAL BUILDING FOOTPRINT</label>
                                    <span class="font-display text-xl font-bold text-[#E05A1B] font-mono">{{ area.toLocaleString() }} SQ FT</span>
                                </div>
                                <input 
                                    v-model.number="area" 
                                    type="range" 
                                    min="500" 
                                    max="50000" 
                                    step="250" 
                                    class="w-full h-2 bg-[#242424] appearance-none cursor-pointer accent-[#E05A1B] rounded-lg"
                                >
                                <div class="flex justify-between text-[8px] font-mono text-[#525252]">
                                    <span>500 SQFT</span>
                                    <span>25,000 SQFT</span>
                                    <span>50,000 SQFT</span>
                                </div>
                            </div>

                            <!-- Sector Type -->
                            <div class="space-y-2">
                                <label class="industrial-badge text-[9px] text-[#A3A3A3] block">PROJECT SECTOR</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <button 
                                        v-for="sec in [
                                            { id: 'residential', label: 'Private Residential' },
                                            { id: 'commercial', label: 'Commercial Complex' },
                                            { id: 'industrial', label: 'Industrial Logistics' },
                                            { id: 'infrastructure', label: 'Heavy Infrastructure' }
                                        ]" 
                                        :key="sec.id"
                                        type="button"
                                        @click="selectedSector = sec.id"
                                        class="p-3 text-left rounded-xl border text-xs font-display font-bold uppercase tracking-wider transition-all"
                                        :class="selectedSector === sec.id ? 'bg-[#242424] border-[#E05A1B] text-white' : 'bg-[#0D0D0D] border-[#242424] text-[#A3A3A3] hover:border-[#525252]'"
                                    >
                                        {{ sec.label }}
                                    </button>
                                </div>
                            </div>

                            <!-- Specification Scope Level -->
                            <div class="space-y-2">
                                <label class="industrial-badge text-[9px] text-[#A3A3A3] block">SPECIFICATION TOLERANCE</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <button 
                                        v-for="scope in ['standard', 'premium', 'luxury']" 
                                        :key="scope"
                                        type="button"
                                        @click="selectedScope = scope"
                                        class="py-3 border text-center rounded-xl text-xs font-display font-bold uppercase tracking-wider transition-all"
                                        :class="selectedScope === scope ? 'bg-[#E05A1B] border-[#E05A1B] text-[#0D0D0D] font-extrabold shadow-md' : 'bg-[#0D0D0D] border-[#242424] text-[#A3A3A3] hover:border-[#525252]'"
                                    >
                                        {{ scope }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Projection Breakdown Result -->
                    <div class="lg:col-span-6">
                        <div class="industrial-panel p-8 sm:p-10 rounded-2xl border border-[#242424] shadow-2xl relative overflow-hidden bg-[#171717] corner-crosshair">
                            
                            <!-- Header Strip -->
                            <div class="flex items-center justify-between border-b border-[#242424] pb-4 mb-8">
                                <span class="industrial-badge text-[#E05A1B] text-[10px]">PARAMETRIC DISPATCH PROJECTION</span>
                                <span class="font-mono text-[9px] text-[#525252]">REV 2026.4</span>
                            </div>

                            <div class="space-y-8">
                                <!-- Big Total Output -->
                                <div>
                                    <span class="industrial-badge text-[9px] text-[#525252] block mb-1">TOTAL ESTIMATED STRUCTURAL BUDGET</span>
                                    <p class="font-display text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                                        {{ formatCurrency(estimation?.total) }}
                                    </p>
                                </div>

                                <!-- Cost Breakdown Items -->
                                <div class="space-y-3 pt-6 border-t border-[#242424]">
                                    <div 
                                        v-for="item in estimation?.breakdown" 
                                        :key="item.label" 
                                        class="flex justify-between items-center text-xs"
                                    >
                                        <span class="text-[#A3A3A3] font-medium">{{ item.label }}</span>
                                        <span class="text-white font-mono font-bold">{{ formatCurrency(item.amount) }}</span>
                                    </div>
                                </div>

                                <!-- Key Telemetry Metrics -->
                                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-[#242424]">
                                    <div class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                        <span class="industrial-badge text-[8px] text-[#525252] block mb-1">ESTIMATED TIMELINE</span>
                                        <p class="font-display text-xl font-bold text-[#E5A93C]">{{ estimation?.timeline }} Weeks</p>
                                    </div>
                                    <div class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                        <span class="industrial-badge text-[8px] text-[#525252] block mb-1">FIELD SQUAD UNITS</span>
                                        <p class="font-display text-xl font-bold text-white">{{ estimation?.resources }} Dedicated Units</p>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <Link 
                                    :href="route('contact')" 
                                    class="block w-full py-4 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] text-center text-xs font-display font-bold uppercase tracking-widest transition-all rounded-xl shadow-lg shadow-[#E05A1B]/20"
                                >
                                    Initiate Full Engineering Dossier
                                </Link>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. 6-Phase Development Protocol -->
        <DevelopmentProtocol />
    </PublicLayout>
</template>
