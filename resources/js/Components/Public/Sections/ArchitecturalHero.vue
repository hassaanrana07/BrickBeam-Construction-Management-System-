<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
    page: Object,
    hero: Object,
});

const heroSectionRef = ref(null);
const heroContentRef = ref(null);
const heroBgRef = ref(null);

let ctx = null;

// Find hero section from page sections or prop
const heroData = computed(() => {
    if (props.hero) return props.hero;
    if (props.page?.sections?.length) {
        const found = props.page.sections.find(s => s.section_key === 'hero' || s.type === 'hero');
        if (found) return found;
    }
    if (props.page?.contentSections?.length) {
        const found = props.page.contentSections.find(s => s.section_key === 'hero' || s.type === 'hero');
        if (found) return found;
    }
    return null;
});

// Fallback high-res heavy excavator construction image
const DEFAULT_HERO_IMAGE = 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070';

const resolveHeroImage = (img) => {
    if (!img) return DEFAULT_HERO_IMAGE;
    if (typeof img === 'string') {
        if (img.startsWith('http://') || img.startsWith('https://')) return img;
        if (img.startsWith('/')) return img;
        return `/storage/${img}`;
    }
    return DEFAULT_HERO_IMAGE;
};

const currentHeroImage = ref(
    resolveHeroImage(heroData.value?.image_url || heroData.value?.image || heroData.value?.content?.image_url || heroData.value?.content?.image)
);

watch(heroData, (newVal) => {
    const raw = newVal?.image_url || newVal?.image || newVal?.content?.image_url || newVal?.content?.image;
    currentHeroImage.value = resolveHeroImage(raw);
}, { deep: true, immediate: true });

const onImageError = () => {
    if (currentHeroImage.value !== DEFAULT_HERO_IMAGE) {
        currentHeroImage.value = DEFAULT_HERO_IMAGE;
    }
};

const titleMain = computed(() => {
    const raw = heroData.value?.heading || heroData.value?.content?.title;
    if (!raw || raw.toLowerCase().includes('build smarter')) return 'BRICKBEAM';
    return raw;
});

const subtitleText = computed(() => {
    const raw = heroData.value?.subheading || heroData.value?.content?.subtitle;
    if (!raw || raw.toLowerCase().includes('manage better')) return null;
    return raw;
});

const descriptionText = computed(() => {
    const raw = heroData.value?.description || heroData.value?.content?.description;
    if (!raw || raw.includes('organized in one place')) {
        return 'Centralize multi-trade ticketing, Earned Value budgets, biometric jobsite safety gates, and 4D BIM digital twins into one unified command center.';
    }
    return raw;
});

const buttonText = computed(() => {
    return heroData.value?.button_text || heroData.value?.content?.button_text || 'Explore Project Portfolio';
});

const buttonLink = computed(() => {
    const link = heroData.value?.button_link || heroData.value?.content?.button_link;
    if (!link || link === '/login') return '/projects';
    return link;
});

onMounted(() => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    ctx = gsap.context(() => {
        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

        tl.from('.hero-badge', { y: 20, opacity: 0, duration: 0.6 })
          .from('.hero-headline-main', { y: 40, opacity: 0, duration: 0.8 }, '-=0.3')
          .from('.hero-headline-sub', { y: 30, opacity: 0, duration: 0.8 }, '-=0.5')
          .from('.hero-subtext', { y: 25, opacity: 0, duration: 0.7 }, '-=0.4')
          .from('.hero-cta-group', { y: 25, opacity: 0, duration: 0.7 }, '-=0.4')
          .from('.hero-stat-item', { y: 20, opacity: 0, duration: 0.6, stagger: 0.1 }, '-=0.3');

        // Cinematic Parallax on Background
        gsap.to(heroBgRef.value, {
            scrollTrigger: {
                trigger: heroSectionRef.value,
                start: 'top top',
                end: 'bottom top',
                scrub: 1.5,
            },
            y: 120,
            scale: 1.08,
            ease: 'none'
        });

        // Content Fade on Scroll
        gsap.to(heroContentRef.value, {
            scrollTrigger: {
                trigger: heroSectionRef.value,
                start: 'top top',
                end: 'bottom top',
                scrub: 1,
            },
            y: 80,
            opacity: 0.3,
            ease: 'none'
        });
    }, heroSectionRef.value);
});

onUnmounted(() => {
    if (ctx) {
        ctx.revert();
    }
});
</script>

<template>
    <section 
        ref="heroSectionRef" 
        class="relative min-h-screen flex flex-col justify-between pt-32 pb-16 px-4 sm:px-6 lg:px-8 overflow-hidden bg-[#0D0D0D] text-white"
    >
        <!-- 1. Giant Full-Screen Background Cinematic Construction Image (Excavator / Heavy Machinery) -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <img 
                ref="heroBgRef"
                :src="currentHeroImage" 
                @error="onImageError"
                alt="Heavy Construction Excavator & Jobsite Machinery" 
                class="w-full h-[120%] -top-[10%] object-cover object-center filter brightness-[0.38] contrast-125 saturate-[0.8] will-change-transform"
                loading="eager"
            >
            <!-- High-Contrast Architectural Dark Vignette Overlays -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-[#0D0D0D]/75 to-[#0D0D0D]/60"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#0D0D0D]/90 via-[#0D0D0D]/50 to-[#0D0D0D]/90"></div>
            <div class="absolute inset-0 cad-grid opacity-25"></div>
            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[700px] h-[700px] bg-[#E05A1B]/10 rounded-full blur-[140px]"></div>
        </div>

        <!-- Spacer for top positioning -->
        <div class="h-6"></div>

        <!-- 2. Center Dominant Architectural Display Typography -->
        <div ref="heroContentRef" class="max-w-5xl mx-auto w-full text-center relative z-10 my-auto py-8 space-y-8">
            
            <!-- Category Badge -->
            <div class="hero-badge inline-flex items-center gap-2.5 px-4 py-1.5 bg-[#171717]/90 border border-[#242424] backdrop-blur-md rounded-full shadow-2xl mx-auto">
                <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                <span class="industrial-badge text-[#A3A3A3] text-[9px] tracking-[0.25em]">
                    ENTERPRISE CONSTRUCTION MANAGEMENT PLATFORM
                </span>
            </div>

            <!-- Giant Display Headline -->
            <div class="space-y-3">
                <h1 class="hero-headline-main font-display text-6xl sm:text-8xl lg:text-9xl font-black text-white tracking-tight leading-none uppercase drop-shadow-2xl">
                    {{ titleMain }}
                </h1>
                <p v-if="subtitleText" class="hero-headline-sub font-display text-2xl sm:text-4xl lg:text-5xl font-black tracking-wider uppercase drop-shadow-md text-[#E05A1B]">
                    {{ subtitleText }}
                </p>
                <p v-else class="hero-headline-sub font-display text-2xl sm:text-4xl lg:text-5xl font-black tracking-wider uppercase drop-shadow-md">
                    <span class="text-white">BUILD.</span>
                    <span class="text-[#A3A3A3] mx-2 sm:mx-3">MANAGE.</span>
                    <span class="text-[#E05A1B]">CONTROL.</span>
                </p>
            </div>

            <!-- Supporting Narrative -->
            <p class="hero-subtext text-base sm:text-xl text-[#D4D4D4] leading-relaxed max-w-3xl mx-auto font-normal drop-shadow">
                {{ descriptionText }}
            </p>

            <!-- Single Primary Action CTA -->
            <div class="hero-cta-group flex items-center justify-center pt-2">
                <Link 
                    :href="buttonLink.startsWith('/') ? buttonLink : ('/' + buttonLink)"
                    class="inline-flex items-center justify-center px-10 py-4 text-xs font-display font-bold uppercase tracking-widest text-[#0D0D0D] bg-[#E05A1B] hover:bg-[#F97316] rounded-xl shadow-2xl shadow-[#E05A1B]/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 group"
                >
                    <span>{{ buttonText }}</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </Link>
            </div>
        </div>

        <!-- 3. Bottom Key Project Statistics Bar -->
        <div class="max-w-7xl mx-auto w-full relative z-10 pt-6 border-t border-white/10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center sm:text-left">
                <div class="hero-stat-item bg-[#171717]/80 backdrop-blur-md p-4 rounded-xl border border-[#242424]">
                    <span class="industrial-badge text-[9px] text-[#737373] block">TOTAL SQ FT DELIVERED</span>
                    <span class="font-display text-base sm:text-lg font-bold text-white mt-0.5 block">2.4M+ Sq Ft</span>
                </div>
                <div class="hero-stat-item bg-[#171717]/80 backdrop-blur-md p-4 rounded-xl border border-[#242424]">
                    <span class="industrial-badge text-[9px] text-[#737373] block">BUDGET VARIANCE</span>
                    <span class="font-display text-base sm:text-lg font-bold text-[#E5A93C] mt-0.5 block">&lt; 0.8% CPI</span>
                </div>
                <div class="hero-stat-item bg-[#171717]/80 backdrop-blur-md p-4 rounded-xl border border-[#242424]">
                    <span class="industrial-badge text-[9px] text-[#737373] block">SAFETY COMPLIANCE</span>
                    <span class="font-display text-base sm:text-lg font-bold text-[#E05A1B] mt-0.5 block">100% Zero-Loss</span>
                </div>
                <div class="hero-stat-item bg-[#171717]/80 backdrop-blur-md p-4 rounded-xl border border-[#242424]">
                    <span class="industrial-badge text-[9px] text-[#737373] block">PORTFOLIO VALUE</span>
                    <span class="font-display text-base sm:text-lg font-bold text-emerald-400 mt-0.5 block">$450M+ Managed</span>
                </div>
            </div>
        </div>
    </section>
</template>
