<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';

const props = defineProps({
    engineers: {
        type: Array,
        default: () => []
    }
});

const defaultEngineers = [
    {
        name: 'Arthur Beam, PE',
        role: 'Principal Structural Director & Founder',
        badge: 'LICENSE #PE-94021',
        specialty: 'Ultra-High-Rise Concrete Cores & Seismic Damper Tuning',
        experience: '22+ Years PMO',
        photo: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974',
        bio: 'Over two decades directing mega-scale structural engineering and commercial infrastructure developments across North America and the Middle East.'
    },
    {
        name: 'Sarah Brick, AIA',
        role: 'Chief Architect & BIM Systems Director',
        badge: 'AIA // LEED FELLOW',
        specialty: '4D Parametric Coordination & High-Performance Envelopes',
        experience: '18+ Years Design',
        photo: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976',
        bio: 'Pioneer in sustainable computational architecture, digital twin fabrication workflows, and zero-defect building envelope integration.'
    },
    {
        name: 'Marcus Steel, CSHM',
        role: 'Head of Field Operations & Jobsite Safety',
        badge: 'OSHA MASTER // CSHM',
        specialty: 'Multi-Crane Logistics & Zero-Harm Safety Gates',
        experience: '16+ Years Field',
        photo: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070',
        bio: 'Oversees institutional site mobilization, multi-trade critical path execution, heavy crane logistics, and biometric hazard mitigation gates.'
    },
    {
        name: 'Elena Vance, CFA',
        role: 'Director of Construction Capital & EVM',
        badge: 'CFA // EVM SPECIALIST',
        specialty: 'Earned Value Metric Audits & CapEx Forecasting',
        experience: '14+ Years Fiscal',
        photo: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961',
        bio: 'Expert in institutional capital allocation, 3-way invoice matching, cash flow variance controls, and transparent lender reporting.'
    },
    {
        name: 'David Vance, PE',
        role: 'Structural Telemetry Director',
        badge: 'PE // SENSOR TELEMETRY',
        specialty: 'IoT Stress Gauges & Robotic Total Station Validation',
        experience: '12+ Years Tech',
        photo: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=1974',
        bio: 'Directs digital jobsite telemetry, deploying sub-millimeter robotic total stations, drone photogrammetry, and live concrete curing sensors.'
    },
    {
        name: 'Maya Lin, LEED AP',
        role: 'Senior BIM Computational Engineer',
        badge: 'LEED AP BD+C',
        specialty: 'Parametric Carbon Modeling & Computational Clash Detection',
        experience: '10+ Years BIM',
        photo: 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=1974',
        bio: 'Specializes in automating federated MEP clash reconciliation, embodied carbon calculations, and fabrication-ready shop model validation.'
    }
];

const resolveStaffPhoto = (photo, idx) => {
    if (!photo) return defaultEngineers[idx % defaultEngineers.length].photo;
    if (typeof photo !== 'string') return defaultEngineers[idx % defaultEngineers.length].photo;
    if (photo.startsWith('http://') || photo.startsWith('https://')) return photo;
    if (photo.startsWith('/')) return photo;
    return `/storage/${photo}`;
};

const activeEngineers = computed(() => {
    if (props.engineers && props.engineers.length > 0) {
        return props.engineers.map((e, idx) => {
            const fallback = defaultEngineers[idx % defaultEngineers.length];
            return {
                name: e.name || fallback.name,
                role: e.role || fallback.role,
                badge: e.badge || (e.is_leadership ? 'EXECUTIVE PMO' : 'ENGINEERING CADRE'),
                specialty: e.specialty || fallback.specialty,
                experience: e.experience || fallback.experience,
                photo: resolveStaffPhoto(e.photo_url || e.photo, idx),
                bio: e.bio || fallback.bio
            };
        });
    }
    return defaultEngineers;
});

const currentIndex = ref(0);
const touchStartX = ref(0);
const touchEndX = ref(0);
let autoplayTimer = null;

const maxIndex = computed(() => {
    return activeEngineers.value.length - 1;
});

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % activeEngineers.value.length;
};

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + activeEngineers.value.length) % activeEngineers.value.length;
};

const goToSlide = (index) => {
    currentIndex.value = index;
};

const startAutoplay = () => {
    stopAutoplay();
    autoplayTimer = setInterval(() => {
        nextSlide();
    }, 6000);
};

const stopAutoplay = () => {
    if (autoplayTimer) {
        clearInterval(autoplayTimer);
        autoplayTimer = null;
    }
};

const handleTouchStart = (e) => {
    touchStartX.value = e.changedTouches[0].screenX;
    stopAutoplay();
};

const handleTouchEnd = (e) => {
    touchEndX.value = e.changedTouches[0].screenX;
    if (touchStartX.value - touchEndX.value > 50) {
        nextSlide();
    } else if (touchEndX.value - touchStartX.value > 50) {
        prevSlide();
    }
    startAutoplay();
};

onMounted(() => {
    startAutoplay();
});

onUnmounted(() => {
    stopAutoplay();
});
</script>

<template>
    <section 
        class="py-24 bg-[#0D0D0D] border-t border-[#242424] relative overflow-hidden text-white"
        @mouseenter="stopAutoplay"
        @mouseleave="startAutoplay"
    >
        <!-- Background CAD Grid -->
        <div class="absolute inset-0 cad-grid opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header & Navigation Controls -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                <div class="max-w-2xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">ENGINEERING CADRE</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white">
                        Executive Engineering Directorate<span class="text-[#E05A1B]">.</span>
                    </h2>
                    <p class="text-[#A3A3A3] text-sm sm:text-base leading-relaxed">
                        Industry-certified structural engineers, architects, and EVM project directors governing every BrickBeam platform deployment.
                    </p>
                </div>

                <!-- Navigation Controls -->
                <div class="flex items-center gap-3">
                    <button 
                        @click="prevSlide"
                        aria-label="Previous Engineer"
                        class="w-12 h-12 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button 
                        @click="nextSlide"
                        aria-label="Next Engineer"
                        class="w-12 h-12 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white flex items-center justify-center transition-all duration-200 active:scale-95 shadow-lg"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Slider Viewport -->
            <div 
                class="overflow-hidden touch-pan-y"
                @touchstart="handleTouchStart"
                @touchend="handleTouchEnd"
            >
                <div 
                    class="flex transition-transform duration-500 ease-out gap-6"
                    :style="{ transform: `translateX(-${currentIndex * (100 / (windowWidth >= 1024 ? 3 : windowWidth >= 640 ? 2 : 1))}%)` }"
                >
                    <!-- Grid presentation fallback for responsive slider -->
                </div>

                <!-- Responsive Track -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div 
                        v-for="(eng, idx) in activeEngineers.slice(currentIndex, currentIndex + 3).concat(
                            currentIndex + 3 > activeEngineers.length ? activeEngineers.slice(0, (currentIndex + 3) - activeEngineers.length) : []
                        )"
                        :key="idx + eng.name"
                        class="industrial-panel bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/60 rounded-2xl overflow-hidden flex flex-col justify-between group shadow-2xl transition-all duration-300 corner-crosshair"
                    >
                        <!-- Engineer Photo with Cinematic Lighting -->
                        <div class="aspect-[4/3] overflow-hidden bg-[#0D0D0D] relative">
                            <img 
                                :src="eng.photo" 
                                :alt="eng.name"
                                class="w-full h-full object-cover filter brightness-[0.82] contrast-115 group-hover:scale-105 transition-transform duration-500 ease-out"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-transparent to-transparent"></div>
                            
                            <!-- Overlay Badge -->
                            <div class="absolute top-3 left-3 px-2.5 py-1 bg-[#0D0D0D]/90 backdrop-blur-md border border-[#242424] rounded text-[9px] font-mono text-[#E05A1B]">
                                {{ eng.badge }}
                            </div>

                            <div class="absolute bottom-3 right-3 px-2.5 py-1 bg-[#171717]/90 backdrop-blur-md border border-[#242424] rounded text-[9px] font-mono text-[#A3A3A3]">
                                {{ eng.experience }}
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 sm:p-7 space-y-4 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <h3 class="font-display text-lg font-bold uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">
                                    {{ eng.name }}
                                </h3>
                                <p class="industrial-badge text-[9px] text-[#E05A1B] block">
                                    {{ eng.role }}
                                </p>
                                <p class="text-[#A3A3A3] text-xs leading-relaxed line-clamp-3 pt-1">
                                    {{ eng.bio }}
                                </p>
                            </div>

                            <!-- Specialty Tag -->
                            <div class="pt-4 border-t border-[#242424]">
                                <span class="industrial-badge text-[8px] text-[#525252] block uppercase tracking-widest mb-1">CORE DISCIPLINE</span>
                                <p class="text-xs font-mono text-[#D4D4D4]">{{ eng.specialty }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dots Indicator -->
            <div class="flex justify-center items-center gap-2 mt-10">
                <button 
                    v-for="(_, idx) in activeEngineers" 
                    :key="idx"
                    @click="goToSlide(idx)"
                    :aria-label="`Go to engineer slide ${idx + 1}`"
                    class="h-1.5 transition-all duration-300 rounded-full"
                    :class="currentIndex === idx ? 'w-8 bg-[#E05A1B]' : 'w-2 bg-[#242424] hover:bg-[#525252]'"
                ></button>
            </div>

        </div>
    </section>
</template>
