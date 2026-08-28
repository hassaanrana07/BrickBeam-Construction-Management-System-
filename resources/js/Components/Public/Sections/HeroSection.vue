<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    content: {
        type: Object,
        default: () => ({})
    }
});

const page = usePage();

// Video Configuration & Fallback
const REMOTE_VIDEO_URL = 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260403_050628_c4e32401-fab4-4a27-b7a8-6e9291cd5959.mp4';
const LOCAL_VIDEO_URL = '/videos/brickbeam-hero.mp4';

const videoRef = ref(null);
const currentVideoSrc = ref(REMOTE_VIDEO_URL);
const isVideoLoaded = ref(false);
const isVideoError = ref(false);

const handleVideoLoaded = () => {
    isVideoLoaded.value = true;
    if (videoRef.value) {
        videoRef.value.play().catch((err) => {
            console.warn('Hero video autoplay error:', err);
        });
    }
};

const handleVideoError = (err) => {
    console.warn('BrickBeam hero remote video failed, trying fallback local video:', err);
    isVideoError.value = true;
    if (currentVideoSrc.value !== LOCAL_VIDEO_URL) {
        currentVideoSrc.value = LOCAL_VIDEO_URL;
        if (videoRef.value) {
            videoRef.value.load();
            videoRef.value.play().catch(() => {});
        }
    }
};

// Page-Specific Hero Heading Lines
const headingLines = computed(() => {
    const url = page.url || '';
    if (props.content?.title && props.content?.title !== 'Structural Integrity.') {
        return [props.content.title];
    }
    if (url.startsWith('/about')) {
        return ['Built around better construction.'];
    }
    if (url.startsWith('/services')) {
        return ['Everything your project needs.'];
    }
    if (url.startsWith('/portfolio')) {
        return ['Projects built with purpose.'];
    }
    if (url.startsWith('/contact')) {
        return ["Let's build better together."];
    }
    // Default Home Page
    return [
        'Build smarter.',
        'Manage better.'
    ];
});

// Page-Specific Hero Subheading
const subheadingText = computed(() => {
    const url = page.url || '';
    if (props.content?.description && props.content?.description !== 'We engineer architectural legacies with industrial precision.') {
        return props.content.description;
    }
    if (url.startsWith('/about')) {
        return 'BrickBeam brings people, projects, and construction operations together in one connected platform.';
    }
    if (url.startsWith('/services')) {
        return 'Manage projects, teams, tasks, budgets, and progress through one centralized construction management system.';
    }
    if (url.startsWith('/portfolio')) {
        return 'Explore the work, systems, and digital solutions created to make construction management more organized and efficient.';
    }
    if (url.startsWith('/contact')) {
        return "Have a project, question, or idea? Connect with us and let's talk about how BrickBeam can help.";
    }
    // Default Home Page
    return 'A construction management platform built to keep projects, teams, tasks, and progress organized in one place.';
});

// Character animation state
const isAnimated = ref(false);

// Fade-in states for other elements
const showSubheading = ref(false);
const showButtons = ref(false);
const showRightTag = ref(false);

onMounted(() => {
    // Ensure video properties are forcefully set for strict browser autoplay policies
    if (videoRef.value) {
        videoRef.value.muted = true;
        videoRef.value.defaultMuted = true;
        videoRef.value.playsInline = true;
        videoRef.value.play().catch(() => {
            // Retry after minimal tick
            setTimeout(() => {
                if (videoRef.value) {
                    videoRef.value.muted = true;
                    videoRef.value.play().catch(() => {});
                }
            }, 300);
        });
    }

    // Initial heading animation delay
    setTimeout(() => {
        isAnimated.value = true;
    }, 50);

    // Subheading delay: 800ms
    setTimeout(() => {
        showSubheading.value = true;
    }, 800);

    // Buttons delay: 1200ms
    setTimeout(() => {
        showButtons.value = true;
    }, 1200);

    // Right Tag delay: 1400ms
    setTimeout(() => {
        showRightTag.value = true;
    }, 1400);
});

// Calculate exact character delay according to formula:
// Initial animation delay: 200ms
// Character delay: 30ms
// (lineIndex * lineLength * charDelay) + (charIndex * charDelay) + initialDelay
const getCharTransitionStyle = (lineIndex, charIndex, lineLength) => {
    const initialDelay = 200;
    const charDelay = 30;
    const delay = initialDelay + (lineIndex * lineLength * charDelay) + (charIndex * charDelay);

    return {
        transition: 'opacity 500ms ease, transform 500ms ease',
        transitionDelay: `${delay}ms`,
        transform: isAnimated.value ? 'translateX(0)' : 'translateX(-18px)',
        opacity: isAnimated.value ? 1 : 0,
        display: 'inline-block'
    };
};

// Smooth scroll handler for Explore BrickBeam button
const scrollToAbout = (e) => {
    const target = document.getElementById('about-section');
    if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
    }
};
</script>

<template>
    <div class="relative min-h-screen w-full flex flex-col justify-between overflow-hidden text-white">
        <!-- Full-Screen Raw Background Video (No dark or gradient overlays) -->
        <video 
            ref="videoRef"
            autoplay 
            loop 
            muted 
            playsinline 
            webkit-playsinline
            preload="auto"
            aria-hidden="true"
            :src="currentVideoSrc"
            @loadeddata="handleVideoLoaded"
            @canplay="handleVideoLoaded"
            @error="handleVideoError"
            class="absolute inset-0 w-full h-full object-cover pointer-events-none z-0"
            style="object-position: center center;"
        >
            <source :src="currentVideoSrc" type="video/mp4" />
        </video>

        <!-- Hero Spacer for Global Layout Navbar -->
        <div class="w-full pt-16 relative z-10"></div>

        <!-- Hero Main Content (Positioned at Bottom of Viewport) -->
        <div class="px-6 md:px-12 lg:px-16 flex-1 flex flex-col justify-end pb-12 lg:pb-16 relative z-10 w-full">
            <div class="lg:grid lg:grid-cols-2 lg:items-end w-full">
                
                <!-- Left Column: Heading, Subheading & Action Buttons -->
                <div class="max-w-2xl">
                    <!-- Character-by-Character Animated Heading -->
                    <h1 
                        class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-normal mb-4 text-white"
                        style="letter-spacing: -0.04em;"
                    >
                        <div 
                            v-for="(line, lineIdx) in headingLines" 
                            :key="lineIdx"
                            class="block leading-[1.08]"
                        >
                            <span 
                                v-for="(char, charIdx) in line.split('')" 
                                :key="charIdx"
                                :style="getCharTransitionStyle(lineIdx, charIdx, line.length)"
                            >
                                {{ char === ' ' ? '\u00A0' : char }}
                            </span>
                        </div>
                    </h1>

                    <!-- Subheading with 800ms Delay Fade-In -->
                    <p 
                        class="text-base md:text-lg text-gray-300 mb-5 transition-opacity ease-out"
                        :style="{
                            opacity: showSubheading ? 1 : 0,
                            transitionDuration: '1000ms'
                        }"
                    >
                        {{ subheadingText }}
                    </p>

                    <!-- Hero Buttons with 1200ms Delay Fade-In -->
                    <div 
                        class="flex flex-wrap gap-4 transition-opacity ease-out"
                        :style="{
                            opacity: showButtons ? 1 : 0,
                            transitionDuration: '1000ms'
                        }"
                    >
                        <!-- Button 1: Primary -->
                        <Link 
                            :href="route('login')" 
                            class="bg-white text-black px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors"
                        >
                            Get Started
                        </Link>

                        <!-- Button 2: Secondary Liquid-Glass -->
                        <a 
                            href="#about-section" 
                            @click="scrollToAbout"
                            class="liquid-glass border border-white/20 text-white px-8 py-3 rounded-lg font-medium hover:bg-white hover:text-black transition-colors cursor-pointer"
                        >
                            Explore BrickBeam
                        </a>
                    </div>
                </div>

                <!-- Right Column: BrickBeam Tag with 1400ms Delay Fade-In -->
                <div 
                    class="flex items-end justify-start lg:justify-end mt-6 lg:mt-0 transition-opacity ease-out"
                    :style="{
                        opacity: showRightTag ? 1 : 0,
                        transitionDuration: '1000ms'
                    }"
                >
                    <div class="liquid-glass border border-white/20 px-6 py-3 rounded-xl">
                        <span class="text-lg md:text-xl lg:text-2xl font-light text-white whitespace-nowrap">
                            Planning. Managing. Building.
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
/* Liquid glass styles inherited from app.css */
</style>
