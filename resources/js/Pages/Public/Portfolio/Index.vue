<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    projects: Array,
    page: Object
});

const activeCategory = ref('All');

const categories = ['All', 'Residential', 'Commercial', 'Industrial', 'Infrastructure'];

const fallbackImages = [
    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070',
    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070',
    'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
    'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071',
    'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2069'
];

const resolveImage = (path, idx) => {
    if (!path) return fallbackImages[idx % fallbackImages.length];
    if (typeof path !== 'string') return fallbackImages[idx % fallbackImages.length];
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

const defaultProjects = [
    {
        id: 1,
        title: 'The Glass Pavilion',
        slug: 'the-glass-pavilion',
        project_type: 'Residential',
        location: 'Malibu, CA',
        execution_status: 'Ongoing',
        progress: 92,
        budget_range: '$4.5M - $6.0M',
        short_description: 'A modern minimalist residential masterpiece featuring cantilevered post-tensioned slabs and panoramic glazing.',
        featured_image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070'
    },
    {
        id: 2,
        title: 'Nexus Office Hub',
        slug: 'nexus-office-hub',
        project_type: 'Commercial',
        location: 'Austin, TX',
        execution_status: 'Completed',
        progress: 100,
        budget_range: '$12M - $15M',
        short_description: 'Adaptive reuse of a historic warehouse into a 120,000 sq ft modern tech campus with exposed steel atrium.',
        featured_image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'
    },
    {
        id: 3,
        title: 'Summit Industrial Park',
        slug: 'summit-industrial-park',
        project_type: 'Industrial',
        location: 'Chicago, IL',
        execution_status: 'Ongoing',
        progress: 78,
        budget_range: '$18M - $22M',
        short_description: 'State-of-the-art logistics center featuring heavy crane infrastructure and automated distribution zones.',
        featured_image: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070'
    },
    {
        id: 4,
        title: 'The Horizon Tower',
        slug: 'the-horizon-tower',
        project_type: 'Residential',
        location: 'Seattle, WA',
        execution_status: 'Ongoing',
        progress: 84,
        budget_range: '$65M - $75M',
        short_description: 'A 34-story residential high-rise with aerodynamic wind-damping core and panoramic marine vistas.',
        featured_image: 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070'
    },
    {
        id: 5,
        title: 'Eco-Terminal Alpha',
        slug: 'eco-terminal-alpha',
        project_type: 'Industrial',
        location: 'Savannah, GA',
        execution_status: 'Ongoing',
        progress: 65,
        budget_range: '$28M - $35M',
        short_description: 'Carbon-neutral port logistics facility with geothermal heating and automated intermodal connectivity.',
        featured_image: 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071'
    },
    {
        id: 6,
        title: 'Urban Greenbelt',
        slug: 'urban-greenbelt',
        project_type: 'Residential',
        location: 'Portland, OR',
        execution_status: 'Completed',
        progress: 100,
        budget_range: '$16M - $20M',
        short_description: 'Mass timber multi-family residential development integrating passive house thermal performance.',
        featured_image: 'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2069'
    }
];

const allProjects = computed(() => {
    if (props.projects && props.projects.length >= 3) {
        return props.projects;
    }
    return defaultProjects;
});

const filteredProjects = computed(() => {
    if (activeCategory.value === 'All') {
        return allProjects.value;
    }
    return allProjects.value.filter(p => {
        const type = (p.project_type || '').toLowerCase();
        return type.includes(activeCategory.value.toLowerCase());
    });
});
</script>

<template>
    <PublicLayout :key="$page.url">
        <Head title="Project Portfolio & Architectural Dossiers — BrickBeam" />

        <!-- 1. HERO SECTION -->
        <section class="relative pt-36 pb-20 lg:pt-44 lg:pb-28 bg-[#0D0D0D] text-white border-b border-[#242424] overflow-hidden">
            <!-- CAD Grid Backdrop -->
            <div class="absolute inset-0 cad-grid opacity-30 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 bg-[#171717] border border-[#242424] rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                        <span class="industrial-badge text-[#A3A3A3] text-[9px] tracking-[0.25em]">
                            PROJECT PORTFOLIO & AS-BUILT DOSSIERS
                        </span>
                    </div>

                    <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.04] text-white">
                        PROJECTS BUILT WITH <span class="text-[#E05A1B]">PRECISION.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-[#A3A3A3] leading-relaxed font-normal">
                        Explore our track record of high-performance commercial towers, bespoke luxury residences, and industrial logistics facilities engineered through BrickBeam.
                    </p>
                </div>
            </div>
        </section>

        <!-- 2. FILTER TABS & PROJECT GRID -->
        <section class="py-24 bg-[#111111] text-white border-b border-[#242424]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-14">
                
                <!-- Category Filter Tabs -->
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <button 
                        v-for="cat in categories" 
                        :key="cat"
                        @click="activeCategory = cat"
                        type="button"
                        class="px-5 py-2.5 rounded-xl text-xs font-display font-bold uppercase tracking-wider transition-all duration-200 border"
                        :class="[
                            activeCategory === cat 
                                ? 'bg-[#E05A1B] border-[#E05A1B] text-[#0D0D0D] shadow-lg shadow-[#E05A1B]/20 font-extrabold' 
                                : 'bg-[#171717] border-[#242424] text-[#A3A3A3] hover:text-white hover:border-[#525252]'
                        ]"
                    >
                        {{ cat }}
                    </button>
                </div>

                <!-- Projects Grid (Distinct high-res images) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <Link 
                        v-for="(project, idx) in filteredProjects" 
                        :key="project.id || project.slug"
                        :href="route('projects.show', project.slug)"
                        class="industrial-panel bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/50 rounded-2xl overflow-hidden shadow-2xl transition-all duration-300 flex flex-col justify-between group corner-crosshair"
                    >
                        <!-- Project Image Container -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-[#0D0D0D]">
                            <img 
                                :src="resolveImage(project.featured_image, idx)" 
                                :alt="project.title"
                                @error="($event) => $event.target.src = fallbackImages[idx % fallbackImages.length]"
                                class="w-full h-full object-cover filter brightness-[0.8] contrast-115 group-hover:scale-105 transition-transform duration-700 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-transparent to-transparent"></div>

                            <!-- Badges Overlay -->
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2">
                                <span class="industrial-badge px-2.5 py-1 bg-[#0D0D0D]/90 border border-[#242424] text-white rounded">
                                    {{ project.project_type }}
                                </span>
                                <span 
                                    class="industrial-badge px-2.5 py-1 rounded"
                                    :class="project.execution_status === 'Completed' ? 'bg-emerald-950/80 border border-emerald-800 text-emerald-400' : 'bg-[#171717] border border-[#E05A1B]/60 text-[#E05A1B]'"
                                >
                                    {{ project.execution_status || 'Ongoing' }}
                                </span>
                            </div>

                            <!-- Budget Tag -->
                            <div class="absolute bottom-3 left-4">
                                <span class="industrial-badge text-[9px] text-[#A3A3A3] bg-[#0D0D0D]/90 px-2.5 py-1 rounded border border-[#242424]">
                                    BUDGET: <span class="text-white font-mono font-bold">{{ project.budget_range || (project.total_budget ? `$${(project.total_budget/1000000).toFixed(1)}M` : '$10M+') }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 sm:p-8 space-y-5 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <p class="industrial-badge text-[9px] text-[#525252]">
                                    📍 {{ project.location || 'United States' }}
                                </p>
                                <h3 class="font-display text-xl font-bold uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">
                                    {{ project.title }}
                                </h3>
                                <p class="text-[#A3A3A3] text-xs leading-relaxed line-clamp-2">
                                    {{ project.short_description }}
                                </p>
                            </div>

                            <!-- Progress Bar -->
                            <div class="space-y-2 pt-4 border-t border-[#242424]">
                                <div class="flex justify-between text-xs font-mono">
                                    <span class="text-[#525252]">PHYSICAL COMPLETION</span>
                                    <span class="text-white font-bold">{{ project.execution_status === 'Completed' ? 100 : (project.progress || 80) }}%</span>
                                </div>
                                <div class="w-full h-1.5 bg-[#242424] rounded-full overflow-hidden">
                                    <div 
                                        class="h-full bg-gradient-to-r from-[#E05A1B] to-[#E5A93C] rounded-full transition-all duration-1000"
                                        :style="{ width: `${project.execution_status === 'Completed' ? 100 : (project.progress || 80)}%` }"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 sm:px-8 py-3.5 bg-[#0D0D0D] border-t border-[#242424] flex items-center justify-between text-xs font-display font-semibold uppercase tracking-wider text-[#A3A3A3] group-hover:text-[#E05A1B]">
                            <span>Inspect Technical Dossier</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </Link>
                </div>

            </div>
        </section>

        <!-- 3. PROJECT INCEPTION BANNER -->
        <section class="py-24 bg-[#0D0D0D] text-center relative overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">
                <span class="industrial-badge text-[#E05A1B] text-[9px]">CAPITAL PROJECT INCEPTION</span>
                
                <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white leading-tight">
                    Deploy With Precision<span class="text-[#E05A1B]">.</span>
                </h2>

                <p class="text-[#A3A3A3] text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                    Bring institutional transparency, precision scheduling, and EVM budget control to your active portfolio.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                    <Link 
                        :href="route('contact')"
                        class="px-8 py-4 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs rounded-xl shadow-lg shadow-[#E05A1B]/20 transition-all duration-300"
                    >
                        Schedule Project Inception
                    </Link>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>
