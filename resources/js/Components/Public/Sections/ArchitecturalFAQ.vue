<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    faqs: {
        type: Array,
        default: () => []
    }
});

const defaultFaqs = [
    { question: 'What is the core architecture of BrickBeam?', answer: 'BrickBeam is an institutional-grade construction management software designed to unify project scheduling, daily field ticketing, trade coordination, and real-time Earned Value budget telemetry into a single high-performance workspace.' },
    { question: 'Who is BrickBeam engineered for?', answer: 'BrickBeam is engineered for General Contractors, Real Estate Developers, Civil Engineering Firms, Architecture Studios, Subcontractor Trade Specialists, and Institutional Project Owners who require zero variance.' },
    { question: 'Can BrickBeam manage multiple multi-tower projects concurrently?', answer: 'Yes. BrickBeam provides an executive multi-project portfolio dashboard allowing leadership to track total capital expenditure, cross-project resource utilization, milestone schedules, and safety benchmarks.' },
    { question: 'How does BrickBeam prevent budget overruns?', answer: 'BrickBeam utilizes Earned Value Management (EVM), tracking Cost Performance Index (CPI) and Schedule Performance Index (SPI) in real time. It automates 3-way matching of purchase orders and invoices to detect cost spikes immediately.' },
    { question: 'Can I manage field teams and subcontractor trades?', answer: 'Yes. BrickBeam features multi-tier role-based access control, allowing foremen to assign daily checklists, track attendance, enforce OSHA safety protocols, and record digital sign-offs.' },
    { question: 'Can construction progress be monitored remotely?', answer: 'Yes. BrickBeam integrates high-resolution drone orthomosaics, 360-degree site walkthroughs, and photo-verified task sign-offs for remote inspections.' },
    { question: 'Can I add custom estimation formulas and unit costs?', answer: 'Yes. The platform provides a dynamic Estimation Engine with configurable square-footage base rates, material multipliers, labor cost indices, and sector adjustments.' },
    { question: 'Is BrickBeam suitable for small and boutique construction teams?', answer: 'Absolutely. While BrickBeam scales to multi-million dollar high-rise developments, boutique contractors and custom home builders can easily start with essential task, budget, and progress tracking modules.' }
];

const activeFaqs = computed(() => {
    return (props.faqs && props.faqs.length > 0) ? props.faqs : defaultFaqs;
});

const openIndex = ref(0);

const toggle = (idx) => {
    openIndex.value = openIndex.value === idx ? null : idx;
};
</script>

<template>
    <section class="py-24 bg-[#111111] border-t border-[#242424] relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                    <span class="industrial-badge text-[#E05A1B] text-[9px]">SYSTEM INQUIRIES</span>
                </div>
                <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                    Frequently Answered Questions<span class="text-[#E05A1B]">.</span>
                </h2>
            </div>

            <!-- Accordion List -->
            <div class="space-y-4">
                <div 
                    v-for="(item, idx) in activeFaqs" 
                    :key="idx" 
                    class="industrial-panel rounded-xl overflow-hidden transition-all duration-300 border border-[#242424]"
                    :class="openIndex === idx ? 'border-[#E05A1B]/50' : 'hover:border-[#383838]'"
                >
                    <button 
                        @click="toggle(idx)"
                        type="button" 
                        class="w-full p-6 text-left flex items-center justify-between gap-4 font-display font-bold text-base sm:text-lg text-white uppercase tracking-tight"
                    >
                        <div class="flex items-center gap-4">
                            <span class="font-mono text-xs text-[#525252]">0{{ idx + 1 }}</span>
                            <span>{{ item.question }}</span>
                        </div>
                        <span class="w-8 h-8 rounded-lg bg-[#242424] text-[#E05A1B] flex items-center justify-center font-bold text-sm flex-shrink-0 transition-transform duration-200" :class="openIndex === idx ? 'rotate-45' : ''">
                            +
                        </span>
                    </button>

                    <div 
                        v-if="openIndex === idx" 
                        class="px-6 pb-6 pt-2 border-t border-[#242424] text-[#A3A3A3] text-sm leading-relaxed"
                    >
                        {{ item.answer }}
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>
