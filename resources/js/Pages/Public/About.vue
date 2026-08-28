<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    page: Object,
    team: Array,
    certifications: Array,
    testimonials: Array
});

const defaultTeam = [
    {
        name: 'Engr. Arthur Beam',
        role: 'Principal Structural Engineer & Founder',
        photo: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974',
        bio: 'Over 22 years of structural engineering and EPC project leadership across major high-rise and commercial infrastructure developments.'
    },
    {
        name: 'Sarah Brick',
        role: 'Chief Architect & Design Director',
        photo: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976',
        bio: 'Specializes in sustainable architectural systems, building information modeling (BIM), and high-performance structural envelopes.'
    },
    {
        name: 'Marcus Steel',
        role: 'Head of Project Operations & Safety',
        photo: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070',
        bio: 'Oversees site execution, OSHA-standard safety protocols, heavy equipment logistics, and critical-path milestone delivery.'
    },
    {
        name: 'Elena Vance',
        role: 'Director of Construction Finance & Estimating',
        photo: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961',
        bio: 'Expert in capital expenditure tracking, procurement risk assessment, and transparent financial lifecycle management.'
    }
];

const values = [
    {
        title: 'Precision Engineering',
        desc: 'We uphold millimeter-grade tolerances in structural calculation, planning schedules, and site execution.',
        icon: '📐'
    },
    {
        title: 'Institutional Transparency',
        desc: 'Real-time financial variance and daily site logging ensure clients and investors always have unfiltered visibility.',
        icon: '🔍'
    },
    {
        title: 'Safety Without Compromise',
        desc: 'Zero-compromise OSHA standards with mandatory digital toolbox talks and proactive hazard mitigation on all job sites.',
        icon: '🛡️'
    },
    {
        title: 'Sustainable Longevity',
        desc: 'Integrating energy-neutral materials, solar microgrids, and LEED-compliant lifecycle practices into modern builds.',
        icon: '🌿'
    },
    {
        title: 'Technological Innovation',
        desc: 'Leveraging 4D BIM, drone photogrammetry, and automated Earned Value telemetry to replace outdated construction friction.',
        icon: '⚡'
    },
    {
        title: 'Client Partnership',
        desc: 'We operate as trusted co-builders, aligning every milestone with the client long-term financial and operational vision.',
        icon: '🤝'
    }
];

const pillars = [
    {
        title: 'Centralized Management',
        desc: 'Single source of truth uniting blueprints, change orders, field logs, and inspections in one connected cloud workspace.'
    },
    {
        title: 'Better Collaboration',
        desc: 'Bridge the communication gap between architects in the studio, subcontractors on the slab, and owners in the boardroom.'
    },
    {
        title: 'Real-Time Project Visibility',
        desc: 'Drone surveys, 360 virtual site walkthroughs, and photo-verified task logs provide true situational awareness anytime.'
    },
    {
        title: 'Strict Financial Control',
        desc: 'Live Earned Value telemetry, automated 3-way invoice matching, and contingency tracking eliminate budget surprises.'
    },
    {
        title: 'Data-Driven Decisions',
        desc: 'Turn millions of jobsite data points into predictive schedule forecasting, subcontractor scorecards, and executive audit packs.'
    }
];
const defaultHero = 'https://images.unsplash.com/photo-1504917595217-d4dc5f566fab?q=80&w=2070';
const fallbackTeamPhoto = 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974';
</script>

<template>
    <PublicLayout>
        <Head title="About Us — BrickBeam Construction Platform" />

        <!-- 1. HERO SECTION -->
        <section class="relative pt-36 pb-24 lg:pt-48 lg:pb-36 bg-[#060913] text-white overflow-hidden border-b border-white/[0.08]">
            <!-- Cinematic Background -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="https://images.unsplash.com/photo-1504917595217-d4dc5f566fab?q=80&w=2070" 
                    @error="($event) => $event.target.src = defaultHero"
                    alt="Structural Engineering & Construction" 
                    class="w-full h-full object-cover object-center filter brightness-[0.3] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#060913] via-[#060913]/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#060913]/95 via-[#060913]/60 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-orange-500/10 border border-orange-500/30 rounded-full backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        <span class="text-[11px] font-black tracking-[0.25em] text-orange-400 uppercase">
                            ABOUT BRICKBEAM
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.08] text-white">
                        WE BUILD MORE THAN <span class="text-orange-500">STRUCTURES.</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-normal">
                        BrickBeam is dedicated to making construction management more organized, transparent, and efficient through engineering rigor and integrated technology.
                    </p>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <Link 
                            :href="route('services')"
                            class="px-8 py-4 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs rounded-xl shadow-xl shadow-orange-500/25 transition-all duration-300"
                        >
                            Explore Capabilities
                        </Link>
                        <Link 
                            :href="route('contact')"
                            class="px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/20 text-white font-black uppercase tracking-widest text-xs rounded-xl backdrop-blur-md transition-all duration-300"
                        >
                            Get in Touch
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. OUR STORY SECTION -->
        <section class="py-28 lg:py-36 bg-[#070a12] relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left: Text Narrative -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-full">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Genesis & Heritage</span>
                        </div>

                        <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white leading-tight">
                            Our Story<span class="text-orange-500">.</span>
                        </h2>

                        <p class="text-slate-300 text-base sm:text-lg leading-relaxed">
                            BrickBeam was founded by veteran structural engineers and construction executives who experienced firsthand the cost of fragmented jobsite communication, delayed drawing approvals, and budget discrepancies.
                        </p>

                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            We set out to create an institutional-grade platform that connects every phase of the construction lifecycle: from early architectural schematics and permit filings to daily field task ticketing, biometric site safety, and automated fiscal audits.
                        </p>

                        <div class="grid grid-cols-2 gap-6 pt-4 border-t border-white/10">
                            <div>
                                <h4 class="text-3xl font-black text-orange-500 tracking-tight">20+</h4>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mt-1">Years Combined Engineering Experience</p>
                            </div>
                            <div>
                                <h4 class="text-3xl font-black text-orange-500 tracking-tight">100%</h4>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mt-1">Audit-Ready Compliance Rate</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Editorial Image Collage -->
                    <div class="lg:col-span-6 relative">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/10 aspect-[4/3] group">
                            <img 
                                src="https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070" 
                                alt="Engineers Reviewing Construction Blueprints" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            
                            <div class="absolute bottom-6 left-6 right-6 p-6 bg-[#0a0f1d]/90 backdrop-blur-md rounded-2xl border border-white/10">
                                <p class="text-[10px] font-black uppercase tracking-widest text-orange-400 mb-1">Guiding Principle</p>
                                <p class="text-sm font-bold text-white leading-snug">"Every millimeter on the blueprint protects millions in the field."</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. MISSION & VISION DUAL CARDS -->
        <section class="py-24 lg:py-32 bg-[#0a0f1d] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    
                    <!-- Mission Card -->
                    <div class="p-10 sm:p-14 bg-[#050811] border border-white/[0.08] rounded-3xl space-y-6 relative overflow-hidden group hover:border-orange-500/50 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-14 h-14 rounded-2xl bg-orange-500/10 border border-orange-500/30 flex items-center justify-center text-orange-400 font-black text-2xl">
                            🎯
                        </div>
                        <h3 class="text-3xl font-black uppercase tracking-tight text-white">
                            Our Mission<span class="text-orange-500">.</span>
                        </h3>
                        <p class="text-slate-300 text-base leading-relaxed">
                            Make construction management more organized, transparent, and efficient by eliminating operational blindspots, standardizing field safety, and aligning trades to verified milestones.
                        </p>
                        <ul class="space-y-3 pt-4 border-t border-white/5 text-sm text-slate-400 font-medium">
                            <li class="flex items-center gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                Eliminate chaotic paper logs and fragmented chat threads
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                Deliver predictable budgets with Earned Value telemetry
                            </li>
                        </ul>
                    </div>

                    <!-- Vision Card -->
                    <div class="p-10 sm:p-14 bg-[#050811] border border-white/[0.08] rounded-3xl space-y-6 relative overflow-hidden group hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-14 h-14 rounded-2xl bg-purple-950/60 border border-purple-500/30 flex items-center justify-center text-purple-300 font-black text-2xl">
                            🔭
                        </div>
                        <h3 class="text-3xl font-black uppercase tracking-tight text-white">
                            Our Vision<span class="text-purple-400">.</span>
                        </h3>
                        <p class="text-slate-300 text-base leading-relaxed">
                            Build a smarter future for construction teams where 4D BIM, drone telemetry, and predictive risk modeling enable zero-defect and zero-accident structural execution across the globe.
                        </p>
                        <ul class="space-y-3 pt-4 border-t border-white/5 text-sm text-slate-400 font-medium">
                            <li class="flex items-center gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                                Establish global standards for digital construction governance
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                                Enable sustainable, energy-neutral architectural longevity
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        <!-- 4. WHY BRICKBEAM? (5 PILLARS) -->
        <section class="py-28 lg:py-36 bg-[#070a12] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="max-w-3xl mb-16 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-500/10 border border-orange-500/20 rounded-full">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Competitive Edge</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                        Why BrickBeam?<span class="text-orange-500">.</span>
                    </h2>
                    <p class="text-slate-400 text-base sm:text-lg">
                        Five architectural pillars engineered to give contractors and owners complete command over their projects.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(pillar, idx) in pillars" 
                        :key="idx"
                        class="p-8 lg:p-10 bg-[#0a0f1d] border border-white/[0.08] hover:border-orange-500/40 rounded-3xl transition-all duration-300 space-y-4 relative group"
                    >
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-orange-400 transition-colors">
                            PILLAR 0{{ idx + 1 }}
                        </span>
                        <h3 class="text-xl font-black uppercase tracking-tight text-white group-hover:text-orange-500 transition-colors">
                            {{ pillar.title }}
                        </h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            {{ pillar.desc }}
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 5. COMPANY VALUES (6 UNIQUE ICONS) -->
        <section class="py-28 lg:py-36 bg-[#0a0f1d] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-full">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Core Foundations</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                        Company Values<span class="text-orange-500">.</span>
                    </h2>
                    <p class="text-slate-400 text-base">
                        The bedrock principles guiding every line of code, blueprint review, and structural inspection.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(val, idx) in values" 
                        :key="idx"
                        class="p-8 bg-[#070a12] border border-white/[0.08] rounded-3xl space-y-4 hover:border-orange-500/40 transition-colors group"
                    >
                        <div class="text-3xl mb-2">{{ val.icon }}</div>
                        <h3 class="text-lg font-black uppercase tracking-tight text-white group-hover:text-orange-500 transition-colors">
                            {{ val.title }}
                        </h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            {{ val.desc }}
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 6. LEADERSHIP TEAM SECTION -->
        <section class="py-28 lg:py-36 bg-[#070a12] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div class="max-w-2xl space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-500/10 border border-orange-500/20 rounded-full">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Executive PMO</span>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                            Engineering Leadership<span class="text-orange-500">.</span>
                        </h2>
                        <p class="text-slate-400 text-base leading-relaxed">
                            Headed by licensed structural engineers, architects, and capital project directors.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div 
                        v-for="(member, idx) in (team?.length ? team : defaultTeam)" 
                        :key="member.id || idx"
                        class="bg-[#0a0f1d] border border-white/[0.08] rounded-3xl overflow-hidden group shadow-xl flex flex-col justify-between"
                    >
                        <div class="aspect-[4/5] overflow-hidden bg-slate-900 relative">
                            <img 
                                :src="member.photo || fallbackTeamPhoto" 
                                @error="($event) => $event.target.src = fallbackTeamPhoto"
                                :alt="member.name"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-transparent to-transparent"></div>
                        </div>

                        <div class="p-6 space-y-2">
                            <h3 class="text-lg font-black uppercase tracking-tight text-white group-hover:text-orange-500 transition-colors">
                                {{ member.name }}
                            </h3>
                            <p class="text-xs font-bold uppercase tracking-wider text-orange-400">
                                {{ member.role }}
                            </p>
                            <p v-if="member.bio" class="text-slate-400 text-xs leading-relaxed pt-2 line-clamp-3">
                                {{ member.bio }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 7. BOTTOM CTA BANNER -->
        <section class="py-24 bg-gradient-to-br from-[#0a0f1d] via-[#0e162e] to-[#070a12] border-t border-white/[0.08] text-center relative overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8">
                <span class="text-xs font-black text-orange-400 uppercase tracking-[0.3em] block">Join the Revolution</span>
                
                <h2 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white leading-tight">
                    Let's Build Something Better<span class="text-orange-500">.</span>
                </h2>

                <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                    Partner with BrickBeam to bring modern precision, safety, and financial control to your next development.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                    <Link 
                        :href="route('contact')"
                        class="px-10 py-5 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs rounded-xl shadow-2xl shadow-orange-500/30 transition-all duration-300"
                    >
                        Schedule an Architectural Consultation
                    </Link>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>
