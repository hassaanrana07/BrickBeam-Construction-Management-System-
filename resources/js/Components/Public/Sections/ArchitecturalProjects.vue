<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    projects: {
        type: Array,
        default: () => []
    }
});

const defaultProjects = [
    {
        title: 'Skyline Residence',
        slug: 'skyline-residence',
        project_type: 'High-Rise Residential',
        location: 'Sector F-7, Islamabad',
        execution_status: 'In Progress',
        progress: 92,
        budget: 'PKR 85M',
        short_description: 'A 6-story ultra-luxury residential development with cantilevered post-tensioned slabs and smart HVAC controls.',
        featured_image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070'
    },
    {
        title: 'Urban Business Tower',
        slug: 'urban-business-center',
        project_type: 'Commercial Grade-A Office',
        location: 'Clifton Block 4, Karachi',
        execution_status: 'In Progress',
        progress: 76,
        budget: 'PKR 140M',
        short_description: 'A 12-story state-of-the-art corporate office tower engineered for financial institutions and tech headquarters.',
        featured_image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'
    },
    {
        title: 'Riverside Eco-Villas',
        slug: 'riverside-villas',
        project_type: 'Masterplanned Community',
        location: 'Bahria Phase 8, Rawalpindi',
        execution_status: 'Completed',
        progress: 100,
        budget: 'PKR 65M',
        short_description: 'Gated master enclave of 18 luxury eco-villas featuring riverside views and solar microgrids.',
        featured_image: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070'
    },
    {
        title: 'Metro Commerce Hub',
        slug: 'metro-office-complex',
        project_type: 'Twin Commercial Towers',
        location: 'Gulberg III, Lahore',
        execution_status: 'In Progress',
        progress: 45,
        budget: 'PKR 220M',
        short_description: 'Twin-tower commercial development featuring high-performance curtain glass and automated parking.',
        featured_image: 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070'
    }
];

const activeProjects = computed(() => {
    return (props.projects && props.projects.length >= 3) ? props.projects : defaultProjects;
});

const defaultImg = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070';
const resolveImage = (path) => {
    if (!path) return defaultImg;
    if (typeof path !== 'string') return defaultImg;
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};
</script>

<template>
    <section class="py-24 bg-[#0D0D0D] border-t border-[#242424] relative overflow-hidden">
        <!-- Subtle CAD Grid -->
        <div class="absolute inset-0 cad-grid opacity-25 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6 border-b border-[#242424] pb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-3">
                        <span class="industrial-badge text-[#E05A1B] text-[9px]">PROJECT DOSSIERS</span>
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase text-white tracking-tight">
                        Featured Developments<span class="text-[#E05A1B]">.</span>
                    </h2>
                </div>

                <Link 
                    :href="route('projects')"
                    class="inline-flex items-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-[#E05A1B] transition-colors"
                >
                    <span>View Project Archive</span>
                    <span>→</span>
                </Link>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                <Link 
                    v-for="project in activeProjects.slice(0, 4)" 
                    :key="project.id || project.slug"
                    :href="route('projects.show', project.slug)"
                    class="industrial-panel rounded-xl overflow-hidden hover-industrial flex flex-col justify-between group shadow-xl corner-crosshair"
                >
                    <!-- Project Image Container -->
                    <div class="relative aspect-[16/10] overflow-hidden bg-[#111111]">
                        <img 
                            :src="resolveImage(project.featured_image)" 
                            @error="($event) => $event.target.src = defaultImg"
                            :alt="project.title"
                            class="w-full h-full object-cover filter brightness-[0.75] contrast-110 group-hover:scale-105 transition-transform duration-700 ease-out"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-transparent to-transparent"></div>

                        <!-- Top Technical Badges -->
                        <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2">
                            <span class="industrial-badge px-2.5 py-1 bg-[#0D0D0D]/90 border border-[#242424] text-white rounded">
                                {{ project.project_type }}
                            </span>
                            <span 
                                class="industrial-badge px-2.5 py-1 rounded"
                                :class="project.execution_status === 'Completed' ? 'bg-green-950/80 border border-green-800 text-green-400' : 'bg-[#171717] border border-[#E05A1B]/60 text-[#E05A1B]'"
                            >
                                {{ project.execution_status || 'In Progress' }}
                            </span>
                        </div>

                        <!-- Budget Stamp -->
                        <div class="absolute bottom-3 left-4">
                            <span class="industrial-badge text-[9px] text-[#A3A3A3] bg-[#0D0D0D]/80 border border-[#242424] px-2.5 py-1 rounded">
                                CAPITAL: <span class="text-white font-mono">{{ project.budget }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Project Metadata & Progress -->
                    <div class="p-6 sm:p-8 space-y-5 flex-1 flex flex-col justify-between bg-[#171717]">
                        <div class="space-y-2">
                            <span class="industrial-badge text-[9px] text-[#525252] block">
                                📍 {{ project.location || 'Islamabad, PK' }}
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
                                <span class="text-[#525252]">PHYSICAL COMPLETION</span>
                                <span class="text-white font-bold">{{ project.progress || 75 }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-[#242424] rounded-full overflow-hidden">
                                <div 
                                    class="h-full bg-gradient-to-r from-[#E05A1B] to-[#E5A93C] rounded-full transition-all duration-1000"
                                    :style="{ width: `${project.progress || 75}%` }"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Action -->
                    <div class="px-6 sm:px-8 py-3.5 bg-[#111111] border-t border-[#242424] flex items-center justify-between text-xs font-display font-semibold uppercase tracking-wider text-[#A3A3A3] group-hover:text-[#E05A1B]">
                        <span>Open Detailed Dossier</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </Link>
            </div>

        </div>
    </section>
</template>
