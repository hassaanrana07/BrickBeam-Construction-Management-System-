<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import SectionRenderer from '@/Components/SectionRenderer.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    faqs: Array,
    page: Object
});

const activeFaq = ref(null);
</script>

<template>
    <PublicLayout>
        <Head :title="page?.title || 'Intelligence Base & FAQs — BrickBeam'" />

        <!-- 1. HERO SECTION -->
        <div class="relative pt-36 pb-20 lg:pt-48 lg:pb-28 bg-[#050811] text-white border-b border-white/[0.08] overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img 
                    src="https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070" 
                    alt="BrickBeam FAQ Intelligence"
                    class="w-full h-full object-cover object-center filter brightness-[0.2] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#050811] via-[#050811]/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#050811]/95 via-[#581c87]/30 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-purple-950/60 border border-purple-500/30 rounded-full backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                        <span class="text-[11px] font-black tracking-[0.25em] text-purple-300 uppercase">
                            KNOWLEDGE BASE & FAQ
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.08] text-white">
                        QUESTIONS & <span class="text-orange-500">ANSWERS.</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-normal">
                        Comprehensive clarity on BrickBeam project workflows, security protocols, multi-trade scheduling, and estimation rules.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ Content -->
        <section class="py-24 lg:py-32 bg-[#050811] text-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-4">
                    <div v-for="faq in faqs" :key="faq.id" 
                        class="border border-white/10 rounded-2xl bg-[#0a0f1d] overflow-hidden transition-colors duration-200"
                        :class="activeFaq === faq.id ? 'border-purple-500/50 shadow-lg shadow-purple-950/20' : 'hover:border-white/20'"
                    >
                        <button 
                            @click="activeFaq = activeFaq === faq.id ? null : faq.id"
                            class="w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-white uppercase text-sm tracking-wide focus:outline-none"
                        >
                            <span>{{ faq.question }}</span>
                            <span 
                                class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-orange-400 font-bold flex-shrink-0 transition-transform duration-300"
                                :class="activeFaq === faq.id ? 'rotate-180 bg-orange-500 text-black' : ''"
                            >
                                ↓
                            </span>
                        </button>
                        
                        <div v-show="activeFaq === faq.id" class="px-6 pb-6 text-slate-400 text-sm leading-relaxed border-t border-white/5 pt-4">
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>

                <!-- Contact CTA -->
                <div class="mt-24 p-12 bg-gradient-to-br from-[#1a0826] to-[#0a0f1d] border border-purple-500/30 text-center rounded-3xl relative overflow-hidden group shadow-2xl">
                    <h4 class="text-2xl sm:text-3xl font-black uppercase tracking-tight mb-4 text-white relative z-10">Still Have Inquiries?</h4>
                    <p class="text-xs text-slate-300 font-bold uppercase tracking-widest mb-8 relative z-10">Direct communication line is open for custom requirements.</p>
                    <a href="/contact" class="inline-block bg-orange-500 hover:bg-white text-black px-10 py-4 text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-orange-500/25 relative z-10 rounded-xl">
                        Start a Project
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.fade-slide-enter-active, .fade-slide-leave-active {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.fade-slide-enter-from, .fade-slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>
