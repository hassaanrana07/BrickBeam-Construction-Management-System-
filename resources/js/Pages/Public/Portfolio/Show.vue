<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    project: Object
});

const resolveImage = (path) => {
    if (!path) return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070';
    if (typeof path !== 'string') return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070';
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

// Fallback gallery images if none exists
const displayGallery = computed(() => {
    if (props.project?.gallery && Array.isArray(props.project.gallery) && props.project.gallery.length > 0) {
        return props.project.gallery;
    }
    return [
        'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070',
        'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
        'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070',
        'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070'
    ];
});

const highlights = computed(() => [
    'Zero lost-time safety incidents recorded over entire execution lifecycle',
    'Full 4D BIM clash-detection implemented prior to structural slab pours',
    'Earned Value variance maintained within ±1.5% of approved capital baseline',
    'Integrated solar microgrid and smart greywater reclamation compliance'
]);
</script>

<template>
    <PublicLayout :key="$page.url">
        <Head :title="`${project.title} — Project Case Study`" />

        <!-- 1. HERO SECTION -->
        <div class="relative pt-36 pb-20 lg:pt-48 lg:pb-28 bg-[#050811] text-white border-b border-white/[0.08] overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    :src="resolveImage(project.featured_image)" 
                    @error="($event) => $event.target.src = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070'"
                    :alt="project.title"
                    class="w-full h-full object-cover object-center filter brightness-[0.22] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#050811] via-[#050811]/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#050811]/95 via-[#581c87]/30 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-4xl space-y-6">
                    <Link 
                        :href="route('projects')" 
                        class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.25em] text-purple-300 hover:text-orange-400 transition-colors"
                    >
                        <span>← Back to Project Archive</span>
                    </Link>

                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="px-3 py-1 bg-purple-950/60 border border-purple-500/30 text-purple-300 text-[10px] font-black uppercase tracking-wider rounded-lg">
                                {{ project.project_type || 'Commercial Development' }}
                            </span>
                            <span 
                                class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg"
                                :class="project.execution_status === 'Completed' ? 'bg-green-500/20 border border-green-500/40 text-green-400' : 'bg-orange-500/20 border border-orange-500/40 text-orange-400'"
                            >
                                {{ project.execution_status || 'In Progress' }}
                            </span>
                        </div>

                        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.08] text-white">
                            {{ project.title }}<span class="text-orange-500">.</span>
                        </h1>
                    </div>

                    <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-normal">
                        {{ project.short_description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. PROJECT CONTENT & METRICS GRID -->
        <section class="py-24 lg:py-32 bg-[#070a12] text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                <!-- Left: Narrative, Structural Protocol, Gallery & Timeline -->
                <div class="lg:col-span-8 space-y-20">
                    
                    <!-- Narrative Overview -->
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-full">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Executive Narrative</span>
                        </div>
                        <h2 class="text-3xl font-black uppercase tracking-tight text-white">
                            Architectural & Engineering Brief<span class="text-orange-500">.</span>
                        </h2>
                        <div class="text-slate-300 text-base sm:text-lg leading-relaxed space-y-6" v-html="project.description"></div>
                    </div>

                    <!-- Progress Bar & Milestones -->
                    <div class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Milestone Telemetry</span>
                                <h3 class="text-xl font-black uppercase text-white">Physical Construction Completion</h3>
                            </div>
                            <span class="text-3xl font-black text-orange-500">{{ project.progress || 85 }}%</span>
                        </div>
                        <div class="w-full h-3 bg-white/5 rounded-full overflow-hidden">
                            <div 
                                class="h-full bg-gradient-to-r from-orange-500 to-amber-400 rounded-full transition-all duration-1000"
                                :style="{ width: `${project.progress || 85}%` }"
                            ></div>
                        </div>
                    </div>

                    <!-- Project Highlights -->
                    <div class="space-y-6">
                        <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-400 border-l-2 border-orange-500 pl-4">Key Engineering Achievements</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div 
                                v-for="(hl, idx) in highlights" 
                                :key="idx" 
                                class="p-6 bg-[#0a0f1d] border border-white/[0.08] rounded-2xl flex items-start gap-4"
                            >
                                <span class="w-2 h-2 rounded-full bg-orange-500 mt-2 flex-shrink-0"></span>
                                <p class="text-slate-300 text-sm font-medium leading-relaxed">{{ hl }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Project Gallery Grid -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-400 border-l-2 border-orange-500 pl-4">Jobsite & Architectural Imagery</h3>
                            <span class="text-xs text-slate-400 uppercase tracking-widest font-bold">Verified Photos</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div 
                                v-for="(img, idx) in displayGallery" 
                                :key="idx" 
                                class="aspect-[4/3] bg-slate-900 rounded-2xl overflow-hidden border border-white/10 group relative"
                            >
                                <img 
                                    :src="resolveImage(img)" 
                                    @error="($event) => $event.target.src = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070'"
                                    :alt="`${project.title} - View ${idx + 1}`"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                >
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-all"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Phased Execution Timeline -->
                    <div class="space-y-8">
                        <h3 class="text-xs font-black uppercase tracking-[0.4em] text-orange-400 border-l-2 border-orange-500 pl-4">5-Phase Construction Timeline</h3>
                        <div class="space-y-4">
                            <div 
                                v-for="i in 5" 
                                :key="i"
                                class="p-6 bg-[#0a0f1d] border border-white/[0.08] rounded-2xl flex items-start gap-6 hover:border-orange-500/40 transition-colors"
                            >
                                <div class="w-10 h-10 rounded-xl bg-orange-500/10 border border-orange-500/30 flex items-center justify-center text-orange-400 font-black text-sm flex-shrink-0">
                                    0{{ i }}
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-sm font-black uppercase tracking-wider text-white">
                                        {{ project['cs_phase_' + i] || `Phase 0${i} Execution & Inspection` }}
                                    </h4>
                                    <p class="text-xs text-slate-400">Complete verification, safety sign-offs, and trade handovers logged.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar: Technical Parameters & Consultation Box -->
                <aside class="lg:col-span-4 space-y-8">
                    
                    <!-- Technical Specs Card -->
                    <div class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-6">
                        <h3 class="text-xs font-black uppercase tracking-[0.3em] text-orange-400 border-b border-white/10 pb-4">
                            Project Dossier
                        </h3>

                        <div class="space-y-4 text-xs font-bold uppercase tracking-wider">
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-slate-400">Location</span>
                                <span class="text-white">{{ project.location || 'Islamabad, PK' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-slate-400">Total Budget</span>
                                <span class="text-orange-400 font-black">{{ project.budget || 'PKR 85M' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-slate-400">Project Type</span>
                                <span class="text-white">{{ project.project_type || 'Residential' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-slate-400">Status</span>
                                <span :class="project.execution_status === 'Completed' ? 'text-green-400' : 'text-orange-400'">
                                    {{ project.execution_status || 'In Progress' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-slate-400">Floors / Scale</span>
                                <span class="text-white">{{ project.total_floors ? `${project.total_floors} Levels` : 'Multi-Tiered' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-slate-400">Assigned Team</span>
                                <span class="text-white">{{ project.cs_team || 'PMO Alpha Unit' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-slate-400">Delivery Method</span>
                                <span class="text-white">Design-Build EPC</span>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Box -->
                    <div class="p-8 bg-gradient-to-br from-[#0e162e] to-[#0a0f1d] border border-orange-500/30 rounded-3xl space-y-6 shadow-2xl">
                        <span class="text-[10px] font-black uppercase tracking-[0.25em] text-orange-400 block">Deploy Similar Project</span>
                        <h4 class="text-2xl font-black uppercase tracking-tight text-white leading-snug">
                            Need Expert Engineering Oversight?
                        </h4>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Schedule an architectural and structural feasibility session with our senior project directors.
                        </p>
                        <Link 
                            :href="route('contact')"
                            class="block w-full py-4 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs text-center rounded-xl shadow-xl transition-all duration-300"
                        >
                            Start Your Project
                        </Link>
                    </div>

                </aside>

            </div>
        </section>

    </PublicLayout>
</template>
