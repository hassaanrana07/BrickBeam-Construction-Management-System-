<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    projects: {
        type: Array,
        default: () => []
    }
});

const defaultProjects = [
    {
        id: 1,
        title: 'The Glass Pavilion',
        slug: 'the-glass-pavilion',
        project_type: 'Luxury Residential',
        location: 'Malibu, CA',
        execution_status: 'Ongoing',
        progress: 92,
        budget_range: '$4.5M - $6.0M',
        client_name: 'Vanguard Architecture',
        short_description: 'A modern minimalist residential masterpiece featuring cantilevered post-tensioned slabs and panoramic glazing.',
        featured_image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070'
    },
    {
        id: 2,
        title: 'Nexus Office Hub',
        slug: 'nexus-office-hub',
        project_type: 'Commercial Tech Campus',
        location: 'Austin, TX',
        execution_status: 'Completed',
        progress: 100,
        budget_range: '$12M - $15M',
        client_name: 'Apex Technology Partners',
        short_description: 'Adaptive reuse of a historic warehouse into a 120,000 sq ft modern tech campus with exposed steel atrium.',
        featured_image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'
    },
    {
        id: 3,
        title: 'Summit Industrial Park',
        slug: 'summit-industrial-park',
        project_type: 'Heavy Industrial & Logistics',
        location: 'Chicago, IL',
        execution_status: 'Ongoing',
        progress: 78,
        budget_range: '$18M - $22M',
        client_name: 'Pinnacle Global Logistics',
        short_description: 'State-of-the-art logistics center featuring heavy crane infrastructure and automated distribution zones.',
        featured_image: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070'
    },
    {
        id: 4,
        title: 'The Horizon Tower',
        slug: 'the-horizon-tower',
        project_type: 'High-Rise Residential',
        location: 'Seattle, WA',
        execution_status: 'Ongoing',
        progress: 84,
        budget_range: '$65M - $75M',
        client_name: 'Cascade Metropolitan',
        short_description: 'A 34-story residential skyscraper engineered with tuned mass damping and floor-to-ceiling glass envelopes.',
        featured_image: 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070'
    },
    {
        id: 5,
        title: 'Eco-Terminal Alpha',
        slug: 'eco-terminal-alpha',
        project_type: 'Port & Intermodal Hub',
        location: 'Savannah, GA',
        execution_status: 'Ongoing',
        progress: 65,
        budget_range: '$28M - $35M',
        client_name: 'Atlantic Maritime Infra',
        short_description: 'Carbon-neutral port logistics facility with geothermal microgrids and robotic intermodal connectivity.',
        featured_image: 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071'
    },
    {
        id: 6,
        title: 'Urban Greenbelt',
        slug: 'urban-greenbelt',
        project_type: 'Mass Timber Sustainable',
        location: 'Portland, OR',
        execution_status: 'Completed',
        progress: 100,
        budget_range: '$16M - $20M',
        client_name: 'Pacific Eco-Housing',
        short_description: 'Cross-laminated timber (CLT) multi-family precinct engineered to strict Passive House energy benchmarks.',
        featured_image: 'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2069'
    }
];

const fallbackImages = [
    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070',
    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070',
    'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
    'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071',
    'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2069'
];

const activeProjectsList = computed(() => {
    if (props.projects && props.projects.length >= 4) {
        return props.projects.map((p, idx) => ({
            id: p.id || idx + 1,
            title: p.title,
            slug: p.slug,
            project_type: p.project_type || 'Industrial & Commercial',
            location: p.location || 'United States',
            execution_status: p.execution_status || 'Ongoing',
            progress: p.execution_status === 'Completed' ? 100 : (p.progress || [92, 100, 78, 84, 65, 100][idx % 6]),
            budget_range: p.budget_range || (p.total_budget ? `$${(p.total_budget/1000000).toFixed(1)}M` : '$10M+'),
            client_name: p.client_name || 'Institutional Client',
            short_description: p.short_description || defaultProjects[idx % defaultProjects.length].short_description,
            featured_image: p.featured_image || fallbackImages[idx % fallbackImages.length]
        }));
    }
    return defaultProjects;
});

const resolveImage = (path, idx) => {
    if (!path) return fallbackImages[idx % fallbackImages.length];
    if (typeof path !== 'string') return fallbackImages[idx % fallbackImages.length];
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

// Carousel rotation state
const currentIndex = ref(0);
const isPaused = ref(false);
let autoRotation = null;

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % activeProjectsList.value.length;
};

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + activeProjectsList.value.length) % activeProjectsList.value.length;
};

const selectSlide = (idx) => {
    currentIndex.value = idx;
};

onMounted(() => {
    autoRotation = setInterval(() => {
        if (!isPaused.value) {
            nextSlide();
        }
    }, 5000);
});

onUnmounted(() => {
    if (autoRotation) clearInterval(autoRotation);
});
</script>

<template>
    <section 
        class="py-24 bg-[#0D0D0D] border-t border-[#242424] relative overflow-hidden"
        @mouseenter="isPaused = true"
        @mouseleave="isPaused = false"
    >
        <!-- Background CAD Wireframe Blueprint -->
        <div class="absolute inset-0 cad-grid opacity-25 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header & Controls -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6 border-b border-[#242424] pb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">3D PROJECT SHOWCASE</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                        Featured Developments<span class="text-[#E05A1B]">.</span>
                    </h2>
                </div>

                <!-- Navigation Controls -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button 
                            @click="prevSlide"
                            class="p-2.5 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white transition-all shadow-md"
                            aria-label="Previous project"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button 
                            @click="nextSlide"
                            class="p-2.5 rounded-xl bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white transition-all shadow-md"
                            aria-label="Next project"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <Link 
                        :href="route('projects')"
                        class="hidden sm:inline-flex items-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-[#E05A1B] transition-colors pl-4 border-l border-[#242424]"
                    >
                        <span>Full Portfolio</span>
                        <span>→</span>
                    </Link>
                </div>
            </div>

            <!-- Horizontal Project Carousel Stream -->
            <div class="overflow-hidden relative py-4">
                <div 
                    class="flex transition-transform duration-700 ease-out gap-8"
                    :style="{ transform: `translateX(-${currentIndex * 50}%)` }"
                >
                    <div 
                        v-for="(project, idx) in [...activeProjectsList, ...activeProjectsList]" 
                        :key="idx"
                        class="w-full sm:w-[calc(50%-16px)] lg:w-[calc(50%-16px)] flex-shrink-0"
                    >
                        <Link 
                            :href="route('projects.show', project.slug)"
                            class="industrial-panel rounded-2xl overflow-hidden flex flex-col justify-between group shadow-2xl corner-crosshair h-full bg-[#171717] hover:border-[#E05A1B]/50 transition-all duration-300"
                        >
                            <!-- Project High-Res Image Container with strictly unique imagery -->
                            <div class="relative aspect-[16/10] overflow-hidden bg-[#111111]">
                                <img 
                                    :src="resolveImage(project.featured_image, idx)" 
                                    :alt="project.title"
                                    @error="($event) => $event.target.src = fallbackImages[idx % fallbackImages.length]"
                                    class="w-full h-full object-cover filter brightness-[0.8] contrast-115 group-hover:scale-105 transition-transform duration-700 ease-out"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-transparent to-transparent"></div>

                                <!-- Top Badges -->
                                <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2">
                                    <span class="industrial-badge px-3 py-1 bg-[#0D0D0D]/90 border border-[#242424] text-white rounded-lg">
                                        {{ project.project_type }}
                                    </span>
                                    <span 
                                        class="industrial-badge px-3 py-1 rounded-lg"
                                        :class="project.execution_status === 'Completed' ? 'bg-emerald-950/80 border border-emerald-800 text-emerald-400' : 'bg-[#171717] border border-[#E05A1B]/60 text-[#E05A1B]'"
                                    >
                                        {{ project.execution_status }}
                                    </span>
                                </div>

                                <!-- Bottom Image Capital Stamp -->
                                <div class="absolute bottom-3 left-4 right-4 flex justify-between items-center">
                                    <span class="industrial-badge text-[9px] text-[#A3A3A3] bg-[#0D0D0D]/90 border border-[#242424] px-2.5 py-1 rounded">
                                        CLIENT: <span class="text-white">{{ project.client_name }}</span>
                                    </span>
                                    <span class="industrial-badge text-[9px] text-[#A3A3A3] bg-[#0D0D0D]/90 border border-[#242424] px-2.5 py-1 rounded font-mono">
                                        BUDGET: <span class="text-[#E5A93C] font-bold">{{ project.budget_range }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Project Metadata & Progress -->
                            <div class="p-6 sm:p-8 space-y-5 flex-1 flex flex-col justify-between bg-[#171717]">
                                <div class="space-y-2">
                                    <span class="industrial-badge text-[9px] text-[#525252] block">
                                        📍 {{ project.location }}
                                    </span>
                                    <h3 class="font-display text-2xl font-bold uppercase text-white group-hover:text-[#E05A1B] transition-colors">
                                        {{ project.title }}
                                    </h3>
                                    <p class="text-[#A3A3A3] text-xs sm:text-sm leading-relaxed line-clamp-2">
                                        {{ project.short_description }}
                                    </p>
                                </div>

                                <!-- Physical Progress Meter -->
                                <div class="space-y-2 pt-4 border-t border-[#242424]">
                                    <div class="flex justify-between text-xs font-mono">
                                        <span class="text-[#525252]">EXECUTION PROGRESS</span>
                                        <span class="text-white font-bold">{{ project.progress }}%</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-[#242424] rounded-full overflow-hidden">
                                        <div 
                                            class="h-full bg-gradient-to-r from-[#E05A1B] to-[#E5A93C] rounded-full transition-all duration-1000"
                                            :style="{ width: `${project.progress}%` }"
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer Action -->
                            <div class="px-6 sm:px-8 py-3.5 bg-[#111111] border-t border-[#242424] flex items-center justify-between text-xs font-display font-semibold uppercase tracking-wider text-[#A3A3A3] group-hover:text-[#E05A1B]">
                                <span>Inspect Detailed Dossier</span>
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Dots Indicator -->
            <div class="flex items-center justify-center gap-2 mt-8">
                <button 
                    v-for="(_, idx) in activeProjectsList" 
                    :key="idx"
                    @click="selectSlide(idx)"
                    class="h-1.5 rounded-full transition-all duration-300"
                    :class="currentIndex === idx ? 'w-8 bg-[#E05A1B]' : 'w-2 bg-[#242424] hover:bg-[#525252]'"
                    :aria-label="`Project slide ${idx + 1}`"
                />
            </div>

        </div>
    </section>
</template>
