<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    page: Object,
    cta: Object,
});

const ctaData = computed(() => {
    if (props.cta) return props.cta;
    if (props.page?.sections?.length) {
        const found = props.page.sections.find(s => s.section_key === 'cta' || s.type === 'cta');
        if (found) return found;
    }
    if (props.page?.contentSections?.length) {
        const found = props.page.contentSections.find(s => s.section_key === 'cta' || s.type === 'cta');
        if (found) return found;
    }
    return null;
});

const title = computed(() => ctaData.value?.heading || ctaData.value?.content?.title || 'Ready to Command Your Next Construction Project?');
const subtitle = computed(() => ctaData.value?.subheading || ctaData.value?.content?.subtitle || 'ENGINEERING DEPLOYMENT');
const description = computed(() => ctaData.value?.description || ctaData.value?.content?.description || 'Deploy BrickBeam across your development portfolio to eliminate budget variances, sync specialty trades, and ensure verified milestone delivery.');
const buttonText = computed(() => ctaData.value?.button_text || ctaData.value?.content?.button_text || 'Schedule Engineering Briefing');
const buttonLink = computed(() => ctaData.value?.button_link || ctaData.value?.content?.button_link || '/contact');
</script>

<template>
    <section class="py-24 bg-[#0D0D0D] border-t border-[#242424] relative overflow-hidden">
        <!-- Subtle CAD Background -->
        <div class="absolute inset-0 cad-grid opacity-30 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="industrial-panel-elevated p-8 sm:p-16 rounded-2xl relative overflow-hidden text-center max-w-4xl mx-auto shadow-2xl corner-crosshair">
                
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-6">
                    <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                    <span class="industrial-badge text-[#E05A1B] text-[9px]">{{ subtitle }}</span>
                </div>

                <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight leading-tight mb-6">
                    {{ title }}
                </h2>

                <p class="text-[#A3A3A3] text-sm sm:text-base leading-relaxed max-w-2xl mx-auto mb-10">
                    {{ description }}
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4">
                    <Link 
                        :href="buttonLink.startsWith('/') ? buttonLink : ('/' + buttonLink)"
                        class="inline-flex items-center justify-center px-8 py-4 text-xs font-display font-bold uppercase tracking-wider text-[#0D0D0D] bg-[#E05A1B] hover:bg-[#F97316] rounded-xl shadow-xl shadow-[#E05A1B]/25 transition-all duration-300 group"
                    >
                        <span>{{ buttonText }}</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </Link>

                    <Link 
                        :href="route('estimate.index')"
                        class="inline-flex items-center justify-center px-8 py-4 text-xs font-display font-bold uppercase tracking-wider text-white bg-[#171717] hover:bg-[#242424] border border-[#242424] hover:border-[#525252] rounded-xl transition-all duration-300"
                    >
                        Launch Cost Estimator
                    </Link>
                </div>

            </div>
        </div>
    </section>
</template>
