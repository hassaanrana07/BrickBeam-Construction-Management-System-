<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    project: Object
});

const defaultImg = 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070';

const resolveImage = (path) => {
    if (!path) return defaultImg;
    if (typeof path !== 'string') return defaultImg;
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

const displayGallery = computed(() => {
    if (props.project?.gallery && Array.isArray(props.project.gallery) && props.project.gallery.length > 0) {
        return props.project.gallery;
    }
    return [
        'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
        'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
        'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070'
    ];
});

const highlights = computed(() => [
    'Zero lost-time safety incidents recorded across the entire construction lifecycle',
    'Full 4D BIM clash-detection implemented prior to structural slab pours',
    'Earned Value variance maintained within ±0.8% of approved capital expenditure baseline',
    'Integrated solar microgrid and smart building IoT energy-neutral compliance'
]);
</script>

<template>
    <PublicLayout :key="$page.url">
        <Head :title="`${project.title} — Project Case Study`" />

        <!-- 1. HERO SECTION -->
        <div class="relative pt-36 pb-20 lg:pt-44 lg:pb-28 bg-[#0D0D0D] text-white border-b border-[#242424] overflow-hidden">
            <!-- Background Image with CAD Overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    :src="resolveImage(project.featured_image)" 
                    @error="($event) => $event.target.src = defaultImg"
                    :alt="project.title"
                    class="w-full h-full object-cover object-center filter brightness-[0.22] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-[#0D0D0D]/80 to-transparent"></div>
                <div class="absolute inset-0 cad-grid opacity-20 pointer-events-none"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-4xl space-y-6">
                    <Link 
                        :href="route('projects')" 
                        class="inline-flex items-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-[#E05A1B] transition-colors"
                    >
                        <span>← Back to Project Archive</span>
                    </Link>

                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="industrial-badge px-3 py-1 bg-[#171717] border border-[#242424] text-[#F3F1EC] rounded-lg">
                                {{ project.project_type || 'Commercial Development' }}
                            </span>
                            <span 
                                class="industrial-badge px-3 py-1 rounded-lg"
                                :class="project.execution_status === 'Completed' ? 'bg-emerald-950/80 border border-emerald-800 text-emerald-400' : 'bg-[#171717] border border-[#E05A1B]/60 text-[#E05A1B]'"
                            >
                                {{ project.execution_status || 'Ongoing' }}
                            </span>
                        </div>

                        <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.04] text-white">
                            {{ project.title }}<span class="text-[#E05A1B]">.</span>
                        </h1>
                    </div>

                    <p class="text-base sm:text-lg text-[#A3A3A3] leading-relaxed font-normal">
                        {{ project.short_description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. PROJECT CONTENT & METRICS GRID -->
        <section class="py-24 bg-[#111111] text-white border-b border-[#242424]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                
                <!-- Left: Narrative, Structural Protocol, Gallery & Timeline -->
                <div class="lg:col-span-8 space-y-16">
                    
                    <!-- Narrative Overview -->
                    <div class="space-y-4">
                        <span class="industrial-badge text-[#E05A1B] text-[9px] block">ARCHITECTURAL & ENGINEERING BRIEF</span>
                        <h2 class="font-display text-2xl sm:text-3xl font-bold uppercase tracking-tight text-white">
                            Structural Specifications & Scope<span class="text-[#E05A1B]">.</span>
                        </h2>
                        <div class="text-[#A3A3A3] text-base leading-relaxed space-y-4" v-html="project.description"></div>
                    </div>

                    <!-- Progress Bar & Milestones -->
                    <div class="p-8 bg-[#171717] border border-[#242424] rounded-2xl space-y-5 shadow-xl corner-crosshair">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <span class="industrial-badge text-[8px] text-[#525252] block mb-1">MILESTONE TELEMETRY</span>
                                <h3 class="font-display text-lg font-bold uppercase text-white">Physical Construction Completion</h3>
                            </div>
                            <span class="font-display text-3xl font-extrabold text-[#E05A1B]">{{ project.execution_status === 'Completed' ? 100 : (project.progress || 85) }}%</span>
                        </div>
                        <div class="w-full h-2 bg-[#242424] rounded-full overflow-hidden">
                            <div 
                                class="h-full bg-gradient-to-r from-[#E05A1B] to-[#E5A93C] rounded-full transition-all duration-1000"
                                :style="{ width: `${project.execution_status === 'Completed' ? 100 : (project.progress || 85)}%` }"
                            ></div>
                        </div>
                    </div>

                    <!-- Project Highlights -->
                    <div class="space-y-4">
                        <span class="industrial-badge text-[#E05A1B] text-[9px] block">KEY ENGINEERING ACHIEVEMENTS</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div 
                                v-for="(hl, idx) in highlights" 
                                :key="idx" 
                                class="p-6 bg-[#171717] border border-[#242424] rounded-xl flex items-start gap-3 text-xs text-[#A3A3A3]"
                            >
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B] mt-1.5 flex-shrink-0"></span>
                                <span>{{ hl }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Gallery Grid -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="industrial-badge text-[#E05A1B] text-[9px]">JOBSITE PHOTOGRAMMETRY</span>
                            <span class="industrial-badge text-[8px] text-[#525252]">VERIFIED AS-BUILT IMAGES</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div 
                                v-for="(img, idx) in displayGallery" 
                                :key="idx" 
                                class="aspect-[4/3] bg-[#0D0D0D] rounded-xl overflow-hidden border border-[#242424] group relative"
                            >
                                <img 
                                    :src="resolveImage(img)" 
                                    @error="($event) => $event.target.src = defaultImg"
                                    :alt="`${project.title} - View ${idx + 1}`"
                                    class="w-full h-full object-cover filter brightness-[0.8] contrast-110 group-hover:scale-105 transition-transform duration-700 ease-out"
                                >
                                <div class="absolute inset-0 bg-[#0D0D0D]/20 group-hover:bg-transparent transition-all"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar: Technical Parameters & Consultation Box -->
                <aside class="lg:col-span-4 space-y-8">
                    
                    <!-- Technical Specs Card -->
                    <div class="p-8 bg-[#171717] border border-[#242424] rounded-2xl space-y-6 shadow-xl corner-crosshair">
                        <h3 class="industrial-badge text-[#E05A1B] text-[10px] border-b border-[#242424] pb-3">
                            PROJECT DOSSIER // METADATA
                        </h3>

                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between items-center py-2 border-b border-[#242424]">
                                <span class="text-[#525252]">Location</span>
                                <span class="text-white font-medium">{{ project.location || 'United States' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[#242424]">
                                <span class="text-[#525252]">Capital Budget</span>
                                <span class="text-[#E5A93C] font-mono font-bold">{{ project.budget_range || (project.total_budget ? `$${(project.total_budget/1000000).toFixed(1)}M` : '$10M+') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[#242424]">
                                <span class="text-[#525252]">Client Entity</span>
                                <span class="text-white font-medium">{{ project.client_name || 'Enterprise Developer' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[#242424]">
                                <span class="text-[#525252]">Project Type</span>
                                <span class="text-white font-medium">{{ project.project_type || 'Commercial' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[#242424]">
                                <span class="text-[#525252]">Status</span>
                                <span :class="project.execution_status === 'Completed' ? 'text-emerald-400' : 'text-[#E05A1B]'" class="font-bold">
                                    {{ project.execution_status || 'Ongoing' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-[#525252]">Delivery Model</span>
                                <span class="text-white font-medium">Design-Build EPC</span>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Box -->
                    <div class="p-8 bg-[#171717] border border-[#242424] rounded-2xl space-y-5 shadow-2xl relative overflow-hidden corner-crosshair">
                        <span class="industrial-badge text-[#E05A1B] text-[9px] block">CAPITAL PROJECT INCEPTION</span>
                        <h4 class="font-display text-xl font-bold uppercase tracking-tight text-white leading-snug">
                            Deploy Similar Engineering Oversight
                        </h4>
                        <p class="text-xs text-[#A3A3A3] leading-relaxed">
                            Schedule an architectural and structural feasibility session with our senior PMO directors.
                        </p>
                        <Link 
                            :href="route('contact')"
                            class="block w-full py-3.5 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs text-center rounded-xl shadow-lg shadow-[#E05A1B]/20 transition-all duration-300"
                        >
                            Initiate Project Inception
                        </Link>
                    </div>

                </aside>

            </div>
        </section>

    </PublicLayout>
</template>
