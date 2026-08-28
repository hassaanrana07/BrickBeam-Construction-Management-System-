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

const resolveImage = (path) => {
    if (!path) return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070';
    if (typeof path !== 'string') return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070';
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

const defaultProjects = [
    {
        id: 1,
        title: 'Skyline Residence',
        slug: 'skyline-residence',
        project_type: 'Residential Construction',
        location: 'Sector F-7, Islamabad',
        execution_status: 'In Progress',
        progress: 92,
        budget: 'PKR 85M',
        short_description: 'A 6-story ultra-luxury residential development with cantilevered balconies and smart energy-neutral HVAC systems.',
        featured_image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070'
    },
    {
        id: 2,
        title: 'Urban Business Center',
        slug: 'urban-business-center',
        project_type: 'Commercial Construction',
        location: 'Clifton Block 4, Karachi',
        execution_status: 'In Progress',
        progress: 76,
        budget: 'PKR 140M',
        short_description: 'A 12-story state-of-the-art corporate office tower engineered for financial institutions and tech headquarters.',
        featured_image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'
    },
    {
        id: 3,
        title: 'Riverside Villas',
        slug: 'riverside-villas',
        project_type: 'Residential Development',
        location: 'Bahria Phase 8, Rawalpindi',
        execution_status: 'Completed',
        progress: 100,
        budget: 'PKR 65M',
        short_description: 'Gated master enclave of 18 luxury eco-villas featuring riverside views and solar microgrids.',
        featured_image: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070'
    },
    {
        id: 4,
        title: 'Metro Office Complex',
        slug: 'metro-office-complex',
        project_type: 'Commercial Development',
        location: 'Gulberg III, Lahore',
        execution_status: 'In Progress',
        progress: 45,
        budget: 'PKR 220M',
        short_description: 'Twin-tower commercial development featuring high-performance curtain glass and automated underground parking.',
        featured_image: 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070'
    },
    {
        id: 5,
        title: 'The Monolith Plaza',
        slug: 'the-monolith-plaza',
        project_type: 'Commercial High-Rise',
        location: 'Downtown Financial District',
        execution_status: 'In Progress',
        progress: 85,
        budget: 'PKR 350M',
        short_description: 'A towering 28-story landmark glass-and-steel skyscraper engineered for global fintech corporations.',
        featured_image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'
    },
    {
        id: 6,
        title: 'Alpha Industrial Hub',
        slug: 'alpha-industrial-hub',
        project_type: 'Industrial Complex',
        location: 'M-3 Industrial City, Faisalabad',
        execution_status: 'In Progress',
        progress: 60,
        budget: 'PKR 180M',
        short_description: 'Heavy-duty 400,000 sq ft smart logistics facility equipped with automated high-bay racking and solar power.',
        featured_image: 'https://images.unsplash.com/photo-1590644365607-1c5a519a7a37?q=80&w=2070'
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
        <Head title="Projects & Case Studies — BrickBeam" />

        <!-- 1. HERO SECTION -->
        <div class="relative pt-36 pb-20 lg:pt-48 lg:pb-28 bg-[#050811] text-white border-b border-white/[0.08] overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070" 
                    @error="($event) => $event.target.src = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070'"
                    alt="BrickBeam Project Showcase"
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
                            PROJECT ARCHIVE & CASE STUDIES
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.08] text-white">
                        PROJECTS BUILT WITH <span class="text-orange-500">PURPOSE.</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-normal">
                        Explore our track record of high-performance commercial towers, luxury residential enclaves, and industrial facilities engineered through BrickBeam.
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. FILTER TABS & PROJECT GRID -->
        <section class="py-24 lg:py-32 bg-[#050811] text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                
                <!-- Category Filter Tabs -->
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <button 
                        v-for="cat in categories" 
                        :key="cat"
                        @click="activeCategory = cat"
                        type="button"
                        class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 border"
                        :class="[
                            activeCategory === cat 
                                ? 'bg-orange-500 border-orange-500 text-black shadow-lg shadow-orange-500/25' 
                                : 'bg-[#0a0f1d] border-white/10 text-slate-400 hover:text-white hover:border-purple-500/40'
                        ]"
                    >
                        {{ cat }}
                    </button>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <Link 
                        v-for="project in filteredProjects" 
                        :key="project.id || project.slug"
                        :href="route('projects.show', project.slug)"
                        class="group bg-[#0a0f1d] border border-white/[0.08] hover:border-orange-500/50 rounded-3xl overflow-hidden shadow-2xl transition-all duration-500 flex flex-col justify-between"
                    >
                        <!-- Project Image Container -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-900">
                            <img 
                                :src="resolveImage(project.featured_image)" 
                                @error="($event) => $event.target.src = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'"
                                :alt="project.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-transparent to-transparent"></div>

                            <!-- Badges Overlay -->
                            <div class="absolute top-4 left-4 right-4 flex flex-wrap items-center justify-between gap-2">
                                <span class="px-3 py-1 bg-black/80 backdrop-blur-md border border-white/10 text-white text-[10px] font-black uppercase tracking-wider rounded-lg">
                                    {{ project.project_type }}
                                </span>
                                <span 
                                    class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg backdrop-blur-md"
                                    :class="project.execution_status === 'Completed' ? 'bg-green-500/20 border border-green-500/40 text-green-400' : 'bg-orange-500/20 border border-orange-500/40 text-orange-400'"
                                >
                                    {{ project.execution_status || 'In Progress' }}
                                </span>
                            </div>

                            <!-- Budget Tag -->
                            <div class="absolute bottom-4 left-4">
                                <span class="text-xs font-bold text-slate-300 bg-black/70 backdrop-blur-md px-3 py-1 rounded-md border border-white/10">
                                    Budget: <span class="text-white font-black">{{ project.budget || 'PKR 85M' }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-8 space-y-6 flex-1 flex flex-col justify-between">
                            <div class="space-y-3">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">
                                    📍 {{ project.location || 'Undisclosed Location' }}
                                </p>
                                <h3 class="text-2xl font-black uppercase tracking-tight text-white group-hover:text-orange-500 transition-colors">
                                    {{ project.title }}
                                </h3>
                                <p class="text-slate-400 text-sm leading-relaxed line-clamp-2">
                                    {{ project.short_description }}
                                </p>
                            </div>

                            <!-- Progress Bar -->
                            <div class="space-y-2 pt-4 border-t border-white/5">
                                <div class="flex justify-between text-xs font-bold uppercase tracking-wider">
                                    <span class="text-slate-400">Milestone Progress</span>
                                    <span class="text-orange-500">{{ project.progress || 80 }}%</span>
                                </div>
                                <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                                    <div 
                                        class="h-full bg-gradient-to-r from-orange-500 to-amber-400 rounded-full transition-all duration-1000"
                                        :style="{ width: `${project.progress || 80}%` }"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-8 py-4 bg-white/[0.02] border-t border-white/5 flex items-center justify-between text-xs font-black uppercase tracking-wider text-orange-500 group-hover:text-white">
                            <span>View Full Case Study</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </Link>
                </div>

            </div>
        </section>

        <!-- 3. PROJECT INQUIRY BANNER -->
        <section class="py-24 bg-gradient-to-br from-[#0a0f1d] via-[#0e162e] to-[#070a12] border-t border-white/[0.08] text-center relative overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8">
                <span class="text-xs font-black text-orange-400 uppercase tracking-[0.3em] block">Ready to Execute?</span>
                
                <h2 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white leading-tight">
                    Start Your Project with BrickBeam<span class="text-orange-500">.</span>
                </h2>

                <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                    Bring institutional transparency, precision scheduling, and financial command to your next construction venture.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                    <Link 
                        :href="route('contact')"
                        class="px-10 py-5 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs rounded-xl shadow-2xl shadow-orange-500/30 transition-all duration-300"
                    >
                        Schedule Project Inception
                    </Link>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>
