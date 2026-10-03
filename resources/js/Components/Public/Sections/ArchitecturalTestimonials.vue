<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    testimonials: {
        type: Array,
        default: () => []
    }
});

const defaultTestimonials = [
    {
        client_name: 'Tariq Mehmood',
        client_position: 'Managing Director',
        client_company: 'Apex Developers & Builders',
        rating: 5,
        testimonial: 'BrickBeam completely transformed our multi-tower project in Islamabad. We eliminated schedule slip and reduced budget variance to under 0.8% across 18 months of execution.'
    },
    {
        client_name: 'Engr. Sarah Siddiqui',
        client_position: 'Lead Structural Consultant',
        client_company: 'Matrix Engineering Consortium',
        rating: 5,
        testimonial: 'The ability to coordinate 30+ specialty trades with live photo verification and Earned Value tracking has saved our consultant team hundreds of administrative hours.'
    },
    {
        client_name: 'Kamran Ali',
        client_position: 'Chief Project Officer',
        client_company: 'Habib Construction Group',
        rating: 5,
        testimonial: 'Institutional-grade transparency. Our investors, lead architects, and site engineers are finally on the exact same page from groundbreaking to facility turnover.'
    }
];

const activeTestimonials = computed(() => {
    return (props.testimonials && props.testimonials.length > 0) ? props.testimonials : defaultTestimonials;
});

const currentIndex = ref(0);

const next = () => {
    currentIndex.value = (currentIndex.value + 1) % activeTestimonials.value.length;
};

const prev = () => {
    currentIndex.value = (currentIndex.value - 1 + activeTestimonials.value.length) % activeTestimonials.value.length;
};
</script>

<template>
    <section class="py-24 bg-[#0D0D0D] border-t border-[#242424] relative overflow-hidden">
        <!-- Subtle CAD Grid -->
        <div class="absolute inset-0 cad-grid opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                    <span class="industrial-badge text-[#E05A1B] text-[9px]">INDUSTRY ENDORSEMENT</span>
                </div>
                <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                    Trusted by Engineering Leaders<span class="text-[#E05A1B]">.</span>
                </h2>
            </div>

            <!-- Testimonial Frame -->
            <div class="max-w-4xl mx-auto">
                <div class="industrial-panel p-8 sm:p-14 rounded-2xl relative shadow-2xl corner-crosshair">
                    
                    <!-- Quote Icon & Star Rating -->
                    <div class="flex items-center justify-between mb-8 border-b border-[#242424] pb-6">
                        <div class="flex items-center gap-1 text-[#E05A1B]">
                            <span v-for="s in (activeTestimonials[currentIndex]?.rating || 5)" :key="s" class="text-lg">★</span>
                        </div>
                        <span class="industrial-badge text-[#525252] text-[10px]">VERIFIED CLIENT DOSSIER</span>
                    </div>

                    <!-- Quote Text -->
                    <blockquote class="text-lg sm:text-2xl text-white font-normal leading-relaxed mb-8">
                        “{{ activeTestimonials[currentIndex]?.testimonial }}”
                    </blockquote>

                    <!-- Author Details & Controls -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-[#242424]">
                        <div>
                            <h4 class="font-display text-base font-bold text-white uppercase">
                                {{ activeTestimonials[currentIndex]?.client_name }}
                            </h4>
                            <p class="text-xs text-[#A3A3A3] mt-0.5">
                                {{ activeTestimonials[currentIndex]?.client_position }} — <span class="text-[#E05A1B]">{{ activeTestimonials[currentIndex]?.client_company }}</span>
                            </p>
                        </div>

                        <!-- Prev / Next Controls -->
                        <div class="flex items-center gap-2 self-end sm:self-auto">
                            <button 
                                @click="prev" 
                                class="w-10 h-10 rounded-lg bg-[#242424] border border-[#383838] text-white hover:bg-[#E05A1B] hover:text-[#0D0D0D] flex items-center justify-center transition-colors"
                                aria-label="Previous Testimonial"
                            >
                                ←
                            </button>
                            <button 
                                @click="next" 
                                class="w-10 h-10 rounded-lg bg-[#242424] border border-[#383838] text-white hover:bg-[#E05A1B] hover:text-[#0D0D0D] flex items-center justify-center transition-colors"
                                aria-label="Next Testimonial"
                            >
                                →
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</template>
