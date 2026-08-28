<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import SectionRenderer from '@/Components/SectionRenderer.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    services: Array,
    page: Object,
    estimation_rules: Array
});

// ── Calculator Logic ──────────────────────────────────────────
const area = ref(1500);
const selectedRuleId = ref(props.estimation_rules?.[0]?.id || null);
const selectedSector = ref('residential');
const selectedScope = ref('standard');

const currentRule = computed(() => 
    props.estimation_rules?.find(r => r.id === selectedRuleId.value) || props.estimation_rules?.[0]
);

const scopeMultipliers = { standard: 1.0, premium: 1.25, luxury: 1.5 };

const estimation = computed(() => {
    if (!currentRule.value) return null;

    const rule = currentRule.value;
    const baseRate = rule.base_rate_per_sqft || 0;
    const matMult = (rule.material_cost_factor || 0);
    const labMult = (rule.labor_cost_factor || 0);
    const sectorMult = (rule.sector_multipliers && rule.sector_multipliers[selectedSector.value]) || 1.0;
    const scopeMult = scopeMultipliers[selectedScope.value] || 1.0;

    const baseCost = area.value * baseRate;
    // Total = BaseCost * (1 + Mat + Lab) * Sector * Scope
    const totalCost = baseCost * (1 + matMult + labMult) * sectorMult * scopeMult;
    
    const weeksPer1K = rule.timeline_weeks_per_1000sqft || 8;
    const estimatedWeeks = Math.max(4, Math.ceil((area.value / 1000) * weeksPer1K * scopeMult));

    return {
        total: Math.round(totalCost),
        breakdown: [
            { label: 'Structural Base', amount: Math.round(baseCost * sectorMult * scopeMult) },
            { label: 'System Multipliers (+' + Math.round((matMult + labMult) * 100) + '%)', amount: Math.round(baseCost * (matMult + labMult) * sectorMult * scopeMult) },
        ],
        timeline: estimatedWeeks,
        resources: Math.ceil(area.value / 500) + (selectedScope.value === 'luxury' ? 2 : 0)
    };
});

const formatCurrency = (val) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0
    }).format(val);
};
</script>

<template>
    <PublicLayout>
        <Head title="Technical Capabilities & Services — BrickBeam" />

        <!-- 1. Cinematic Hero Section -->
        <div class="relative pt-36 pb-20 lg:pt-48 lg:pb-28 bg-[#050811] text-white border-b border-white/[0.08] overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070" 
                    @error="($event) => $event.target.src = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070'"
                    alt="Construction Capabilities & Services" 
                    class="w-full h-full object-cover object-center filter brightness-[0.25] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#050811] via-[#050811]/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#050811]/95 via-[#581c87]/30 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-purple-950/60 border border-purple-500/30 rounded-full backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                        <span class="text-[11px] font-black tracking-[0.25em] text-purple-300 uppercase">
                            TECHNICAL CAPABILITIES MATRIX
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.08] text-white">
                        SYSTEM <span class="text-orange-500">CAPABILITIES.</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-normal">
                        Industrial-grade construction solutions engineered for scale, precision scheduling, and architectural legacy.
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. Services Grid -->
        <section class="py-24 lg:py-32 bg-[#050811]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(service, idx) in services" 
                        :key="service.id || idx" 
                        class="bg-[#0a0f1d] p-10 lg:p-12 border border-white/[0.08] hover:border-purple-500/60 transition-all duration-500 group relative rounded-3xl shadow-xl flex flex-col justify-between hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-950/30"
                    >
                        <div class="space-y-4 mb-8">
                            <span class="text-[10px] font-black text-purple-400 group-hover:text-orange-400 uppercase tracking-widest block transition-colors">
                                MODULE 0{{ idx + 1 }}
                            </span>
                            <h2 class="text-2xl font-black uppercase tracking-tight text-white group-hover:text-orange-500 transition-colors">
                                {{ service.title }}
                            </h2>
                            <p class="text-slate-400 leading-relaxed text-sm">
                                {{ service.short_description }}
                            </p>
                        </div>
                        
                        <div class="pt-6 border-t border-white/5 flex items-center justify-between">
                            <Link :href="route('services.show', service.slug || '')" class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-widest text-orange-500 group-hover:text-white transition-colors">
                                <span>View Specification</span>
                                <span>→</span>
                            </Link>
                        </div>
                        <div class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-purple-600 to-orange-500 group-hover:w-full transition-all duration-500"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Launch Estimate Module Activation -->
        <section class="py-32 bg-[#03050a] text-white overflow-hidden border-t border-white/[0.08]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div>
                        <span class="text-xs font-black text-purple-400 uppercase tracking-[0.3em] mb-6 block font-bold">Launch Estimate Module</span>
                        <h2 class="text-5xl md:text-7xl font-black uppercase tracking-tighter leading-tight mb-8">
                            Project Cost<br/>Calculator<span class="text-orange-500">.</span>
                        </h2>
                        <p class="text-lg text-slate-400 mb-12 leading-relaxed">
                            Our proprietary estimation engine utilizes localized labor indices and material logistics factors to provide immediate structural budget projections.
                        </p>

                        <div class="space-y-10">
                            <!-- Area Input -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-end">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Area (Sq. Ft)</label>
                                    <span class="text-2xl font-black text-orange-500 tracking-tighter">{{ area.toLocaleString() }} SQFT</span>
                                </div>
                                <input v-model="area" type="range" min="500" max="25000" step="100" class="w-full h-2 bg-purple-950/60 appearance-none cursor-pointer accent-orange-500 rounded-lg">
                            </div>

                            <!-- Category & Sector -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Project Category</label>
                                    <select v-model="selectedRuleId" class="w-full bg-[#0a0f1d] border border-white/10 text-sm font-bold p-4 focus:ring-1 focus:ring-orange-500 rounded-xl text-white">
                                        <option v-for="rule in estimation_rules" :key="rule.id" :value="rule.id">{{ rule.name }}</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Sector Type</label>
                                    <select v-model="selectedSector" class="w-full bg-[#0a0f1d] border border-white/10 text-sm font-bold p-4 focus:ring-1 focus:ring-orange-500 rounded-xl text-white">
                                        <option value="residential">Private Residential</option>
                                        <option value="commercial">Commercial Estate</option>
                                        <option value="industrial">Industrial Complex</option>
                                        <option value="government">Government Infrastructure</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Scope Level -->
                            <div class="space-y-4">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">Scope Level</label>
                                <div class="grid grid-cols-3 gap-4">
                                    <button v-for="scope in ['standard', 'premium', 'luxury']" :key="scope"
                                        @click="selectedScope = scope"
                                        :class="selectedScope === scope ? 'bg-orange-500 border-orange-500 text-black shadow-lg shadow-orange-500/20 font-black' : 'bg-[#0a0f1d] border-white/10 text-slate-400 hover:border-purple-500/50'"
                                        class="py-4 border text-[10px] font-black uppercase tracking-widest transition-all rounded-xl">
                                        {{ scope }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Card -->
                    <div class="bg-[#0a0f1d] border border-purple-900/30 text-white p-12 md:p-16 rounded-3xl shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-600/10 -mr-16 -mt-16 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                        
                        <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-400 mb-12">Deployment Projection</h3>
                        
                        <div class="space-y-12">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Estimated Cost</p>
                                <p class="text-6xl md:text-7xl font-black tracking-tighter leading-none italic text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-100 to-orange-400">{{ formatCurrency(estimation?.total) }}</p>
                            </div>

                            <div class="space-y-6 pt-12 border-t border-white/10">
                                <div v-for="item in estimation?.breakdown" :key="item.label" class="flex justify-between items-center text-xs font-black uppercase tracking-widest">
                                    <span class="text-slate-400">{{ item.label }}</span>
                                    <span class="text-white">{{ formatCurrency(item.amount) }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-8 pt-6">
                                <div class="bg-black/40 p-6 rounded-2xl border border-white/10">
                                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2">Timeline</p>
                                    <p class="text-2xl font-black italic text-orange-400">{{ estimation?.timeline }} <span class="text-xs uppercase opacity-60 ml-1 text-slate-300">Weeks</span></p>
                                </div>
                                <div class="bg-black/40 p-6 rounded-2xl border border-white/10">
                                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2">Personnel</p>
                                    <p class="text-2xl font-black italic text-purple-400">{{ estimation?.resources }} <span class="text-xs uppercase opacity-60 ml-1 text-slate-300">Units</span></p>
                                </div>
                            </div>

                            <Link :href="route('contact')" class="block w-full py-6 bg-orange-500 hover:bg-white text-black text-center text-xs font-black uppercase tracking-[0.3em] transition-all rounded-xl shadow-xl shadow-orange-500/25">
                                Initiate Full Structural Audit
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Deployment Protocol -->
        <section class="py-32 bg-[#050811] text-white overflow-hidden border-t border-white/[0.08]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-24">
                    <h3 class="text-4xl font-black uppercase tracking-tighter mb-4">Our Deployment Protocol</h3>
                    <p class="text-purple-400 uppercase tracking-widest text-xs font-bold">Six Phases of Industrial Execution</p>
                </div>
                
                <div class="grid grid-cols-2 lg:grid-cols-6 gap-8">
                    <div v-for="i in 6" :key="i" class="text-center space-y-4">
                        <div class="w-16 h-16 bg-[#0a0f1d] border border-white/10 flex items-center justify-center mx-auto text-orange-400 font-black text-xl rounded-2xl transition-all hover:border-purple-500 hover:scale-110 shadow-lg">{{ i }}</div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Phase {{ i }}</p>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
