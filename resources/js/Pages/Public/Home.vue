<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
    page: Object,
    featured_services: Array,
    projects: Array,
    testimonials: Array,
    faqs: Array
});

// Fallback services
const defaultServices = [
    {
        title: 'Project Management',
        slug: 'project-management',
        short_description: 'Plan and control construction projects from a centralized workspace with predictive milestone tracking.',
        icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'
    },
    {
        title: 'Task Management',
        slug: 'task-management',
        short_description: 'Assign responsibilities, monitor deadlines, and keep field and office teams aligned.',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'
    },
    {
        title: 'Team Management',
        slug: 'team-management',
        short_description: 'Manage project teams, subcontractor trades, labor allocation, and safety compliance efficiently.',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
    },
    {
        title: 'Budget & Finance',
        slug: 'budget-management',
        short_description: 'Track budgets, purchase orders, expenses, and project cashflow with zero cost surprises.',
        icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    },
    {
        title: 'Progress Tracking',
        slug: 'progress-tracking',
        short_description: 'Monitor real-time project completion and identify delays before they become expensive problems.',
        icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'
    },
    {
        title: 'Reports & Analytics',
        slug: 'reports-analytics',
        short_description: 'Turn complex project data into automated executive reports and actionable business insights.',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
    }
];

const iconMap = {
    'home-icon': 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    'building-icon': 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
    'factory-icon': 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
    'project-management': 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
    'task-management': 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
    'team-management': 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
    'budget-management': 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    'progress-tracking': 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
    'reports-analytics': 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
};

const getIconPath = (icon, slug) => {
    if (icon && (icon.startsWith('M') || icon.startsWith('m'))) {
        return icon;
    }
    if (icon && iconMap[icon]) {
        return iconMap[icon];
    }
    if (slug && iconMap[slug]) {
        return iconMap[slug];
    }
    return 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4';
};

const displayServices = computed(() => {
    if (props.featured_services && props.featured_services.length >= 4) {
        return props.featured_services;
    }
    return defaultServices;
});

const defaultProjects = [
    {
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
        title: 'Metro Office Complex',
        slug: 'metro-office-complex',
        project_type: 'Commercial Development',
        location: 'Gulberg III, Lahore',
        execution_status: 'In Progress',
        progress: 45,
        budget: 'PKR 220M',
        short_description: 'Twin-tower commercial development featuring high-performance curtain glass and automated underground parking.',
        featured_image: 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070'
    }
];

const displayProjects = computed(() => {
    if (props.projects && props.projects.length >= 3) {
        return props.projects;
    }
    return defaultProjects;
});

// Image helper with reliable fallback
const defaultHeroImg = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070';
const resolveImage = (path) => {
    if (!path) return defaultHeroImg;
    if (typeof path !== 'string') return defaultHeroImg;
    if (path.startsWith('http')) return path;
    if (path.startsWith('/storage/')) return path;
    if (path.startsWith('storage/')) return '/' + path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
};

// Animated Number Counters
const stats = ref([
    { label: 'Projects Managed', target: 150, suffix: '+', current: 0 },
    { label: 'On-Time Completion', target: 98, suffix: '%', current: 0 },
    { label: 'Professional Teams', target: 45, suffix: '+', current: 0 },
    { label: 'Project Value Managed', target: 250, prefix: 'PKR ', suffix: 'M+', current: 0 }
]);

const statsSectionRef = ref(null);
let countersStarted = false;

const startCounters = () => {
    if (countersStarted) return;
    countersStarted = true;

    stats.value.forEach(stat => {
        const duration = 1800;
        const startTime = performance.now();
        const update = (now) => {
            const progress = Math.min((now - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            stat.current = Math.floor(ease * stat.target);
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                stat.current = stat.target;
            }
        };
        requestAnimationFrame(update);
    });
};

// Why BrickBeam 5 Pillars
const pillars = [
    { title: 'Centralized Project Command', desc: 'One single digital source of truth unifying blueprints, daily tickets, RFIs, and approvals.', icon: '🏢' },
    { title: 'Multi-Trade Coordination', desc: 'Sync civil, structural, MEP, and finish trades on one unified critical path schedule.', icon: '🤝' },
    { title: 'Real-Time Field Telemetry', desc: 'Drone orthomosaics, 360-degree walkthroughs, and photo-verified task logs.', icon: '📡' },
    { title: 'Strict Financial Control', desc: 'Live Earned Value telemetry, PO matching, and automated variance warnings.', icon: '📊' },
    { title: 'Data-Driven Decisions', desc: 'Turn millions of jobsite events into predictive delay forecasts and audit-ready reports.', icon: '⚡' }
];

// Construction Process
const processes = [
    { step: '01', title: 'Plan & Baseline', desc: 'Upload drawings, configure work breakdown structures, and establish cost & time baselines.' },
    { step: '02', title: 'Field Dispatch & Ticketing', desc: 'Assign daily checklists and safety protocols directly to field engineers and subcontractors.' },
    { step: '03', title: 'Telemetry & Inspection', desc: 'Inspect progress via geo-tagged photos, drone maps, and quality sign-off gates.' },
    { step: '04', title: 'Milestone Handover', desc: 'Generate tamper-evident audit dossiers, cost reconciliations, and facility turnover packages.' }
];

// Fallback Testimonials
const defaultTestimonials = [
    {
        client_name: 'Tariq Mehmood',
        client_position: 'Managing Director',
        client_company: 'Apex Developers',
        rating: 5,
        testimonial: 'BrickBeam completely transformed our multi-tower project in Islamabad. We eliminated schedule slip and reduced budget variance to under 1%.'
    },
    {
        client_name: 'Engr. Sarah Siddiqui',
        client_position: 'Lead Structural Consultant',
        client_company: 'Matrix Engineering Group',
        rating: 5,
        testimonial: 'The ability to coordinate 30+ specialty trades with live photo verification and Earned Value tracking has saved our team hundreds of hours.'
    },
    {
        client_name: 'Kamran Ali',
        client_position: 'Chief Project Officer',
        client_company: 'Habib Construction Consortium',
        rating: 5,
        testimonial: 'Institutional-grade transparency. Our investors and architects are finally on the exact same page from excavation to handover.'
    }
];

const currentTestimonialIndex = ref(0);
const activeTestimonials = computed(() => {
    return (props.testimonials && props.testimonials.length > 0) ? props.testimonials : defaultTestimonials;
});

const nextTestimonial = () => {
    currentTestimonialIndex.value = (currentTestimonialIndex.value + 1) % activeTestimonials.value.length;
};
const prevTestimonial = () => {
    currentTestimonialIndex.value = (currentTestimonialIndex.value - 1 + activeTestimonials.value.length) % activeTestimonials.value.length;
};

// 8 Comprehensive FAQ Items
const defaultFaqs = [
    { question: 'What is BrickBeam?', answer: 'BrickBeam is an institutional-grade construction management platform designed to centralize project planning, field task ticketing, trade coordination, budget tracking, and real-time milestone monitoring into a single unified workspace.' },
    { question: 'Who is BrickBeam designed for?', answer: 'BrickBeam is engineered for General Contractors, Real Estate Developers, Civil Engineering Firms, Architecture Studios, Subcontractor Trade Specialists, and Project Owners who require transparency and precision.' },
    { question: 'Can BrickBeam manage multiple projects concurrently?', answer: 'Yes. BrickBeam provides an executive multi-project portfolio dashboard allowing leadership to track total capital expenditure, cross-project resource utilization, milestone schedules, and safety benchmarks.' },
    { question: 'How does BrickBeam prevent budget overruns?', answer: 'BrickBeam utilizes Earned Value Management (EVM), tracking Cost Performance Index (CPI) and Schedule Performance Index (SPI) in real time. It automates 3-way matching of purchase orders and invoices to detect cost spikes immediately.' },
    { question: 'Can I manage field teams and subcontractor trades?', answer: 'Yes. BrickBeam features multi-tier role-based access control, allowing foremen to assign daily checklists, track attendance, enforce OSHA safety protocols, and record digital sign-offs.' },
    { question: 'Can construction progress be monitored remotely?', answer: 'Yes. BrickBeam integrates high-resolution drone orthomosaics, 360-degree site walkthroughs, and photo-verified task sign-offs for remote inspections.' },
    { question: 'Can I add custom services and estimation rules?', answer: 'Yes. The platform provides a dynamic Estimation Engine with configurable square-footage base rates, material multipliers, labor cost indices, and sector adjustments.' },
    { question: 'Is BrickBeam suitable for small and medium construction teams?', answer: 'Absolutely. While BrickBeam scales to multi-million dollar high-rise developments, boutique contractors and custom home builders can easily start with essential task, budget, and progress tracking modules.' }
];

const activeFaqIndex = ref(0);
const toggleFaq = (index) => {
    activeFaqIndex.value = activeFaqIndex.value === index ? null : index;
};

onMounted(() => {
    if (statsSectionRef.value) {
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                startCounters();
                observer.disconnect();
            }
        }, { threshold: 0.2 });
        observer.observe(statsSectionRef.value);
    } else {
        startCounters();
    }
});
</script>

<template>
    <PublicLayout>
        <Head title="BrickBeam — Construction Management System" />

        <!-- 1. HERO SECTION -->
        <section class="relative min-h-[95vh] lg:min-h-screen flex items-center justify-center pt-28 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden bg-[#060913]">
            <!-- Background Image with cinematic architectural overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    :src="defaultHeroImg"
                    @error="($event) => $event.target.src = defaultHeroImg"
                    alt="Modern Construction Architecture" 
                    class="w-full h-full object-cover object-center filter brightness-[0.38] contrast-125 scale-105 transition-transform duration-1000 ease-out"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#060913] via-[#060913]/60 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#060913]/90 via-[#060913]/40 to-transparent"></div>
                <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
            </div>

            <div class="max-w-7xl mx-auto w-full relative z-10">
                <div class="max-w-3xl space-y-8">
                    
                    <!-- Small Label Badge -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-orange-500/10 border border-orange-500/30 rounded-full backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        <span class="text-[11px] font-black tracking-[0.25em] text-orange-400 uppercase">
                            BRICKBEAM CONSTRUCTION MANAGEMENT
                        </span>
                    </div>

                    <!-- Main Heading -->
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.08] uppercase">
                        BUILD WITH <span class="text-orange-500">CONFIDENCE.</span><br />
                        MANAGE WITH <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-200 to-slate-400">PRECISION.</span>
                    </h1>

                    <!-- Supporting Text -->
                    <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-2xl font-normal">
                        BrickBeam brings projects, teams, tasks, budgets and progress into one powerful construction management platform.
                    </p>

                    <!-- Hero Action Buttons -->
                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <Link 
                            :href="route('projects')"
                            class="inline-flex items-center justify-center px-8 py-4 text-xs font-black uppercase tracking-widest text-black bg-orange-500 hover:bg-white rounded-xl shadow-xl shadow-orange-500/25 hover:shadow-white/20 transition-all duration-300 group"
                        >
                            <span>Explore Projects</span>
                            <svg class="w-4 h-4 ml-2.5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </Link>

                        <Link 
                            :href="route('services')"
                            class="inline-flex items-center justify-center px-8 py-4 text-xs font-black uppercase tracking-widest text-white bg-white/5 hover:bg-white/15 border border-white/20 rounded-xl backdrop-blur-md transition-all duration-300"
                        >
                            Discover Our Services
                        </Link>
                    </div>

                    <!-- Key Indicators Tagline -->
                    <div class="pt-6 flex flex-wrap items-center gap-6 text-xs text-slate-400 border-t border-white/10">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Live Milestone Tracking</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Earned Value Budget Control</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Multi-Trade Coordination</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 2. STATS SECTION (Animated Counters) -->
        <section ref="statsSectionRef" class="py-16 bg-[#0a0f1d] border-y border-white/[0.08] relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
                    <div 
                        v-for="(stat, idx) in stats" 
                        :key="idx" 
                        class="p-6 bg-white/[0.02] border border-white/5 rounded-2xl relative overflow-hidden group hover:border-orange-500/40 transition-colors duration-300"
                    >
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight mb-2 flex items-baseline">
                            <span>{{ stat.prefix || '' }}</span>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-500">{{ stat.current }}</span>
                            <span class="text-orange-500 text-2xl sm:text-3xl lg:text-4xl">{{ stat.suffix }}</span>
                        </div>
                        <p class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-400">
                            {{ stat.label }}
                        </p>
                        <div class="absolute bottom-0 left-0 h-1 w-0 bg-orange-500 group-hover:w-full transition-all duration-500"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. EDITORIAL ABOUT PREVIEW -->
        <section class="py-28 lg:py-36 bg-[#060913] relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left: Large Architecture Image & Badges -->
                    <div class="lg:col-span-6 relative">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/10 aspect-[4/3] group">
                            <img 
                                src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071" 
                                @error="($event) => $event.target.src = defaultHeroImg"
                                alt="Construction Planning & Architecture" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            
                            <!-- Floating Metric Card -->
                            <div class="absolute bottom-6 left-6 right-6 p-6 bg-black/80 backdrop-blur-md rounded-2xl border border-white/10 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-orange-400">Execution Standard</p>
                                    <h4 class="text-base font-bold text-white">Zero Variance Project Delivery</h4>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-black font-black text-lg">
                                    ✓
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Narrative Content -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-full">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Our Strategic Philosophy</span>
                        </div>

                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black uppercase tracking-tight text-white leading-tight">
                            Built Around Better Construction Management<span class="text-orange-500">.</span>
                        </h2>

                        <p class="text-slate-300 text-base sm:text-lg leading-relaxed">
                            BrickBeam solves the persistent challenges of fragmented communication, cost overruns, and schedule slip in modern construction. By centralizing daily task ticketing, subcontractor logistics, and financial variance tracking, we empower project teams to execute with unmatched efficiency.
                        </p>

                        <div class="space-y-4 pt-2">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-orange-500/10 border border-orange-500/30 flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-base">Centralized Project Command</h3>
                                    <p class="text-slate-400 text-sm leading-normal">Eliminate silos between architects, site engineers, general contractors, and owners.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-orange-500/10 border border-orange-500/30 flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-base">Real-Time Risk & Budget Mitigation</h3>
                                    <p class="text-slate-400 text-sm leading-normal">Instant Earned Value telemetry alerts you to budget threshold spikes before they compound.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <Link 
                                :href="route('about')"
                                class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.2em] text-orange-500 hover:text-white transition-colors group"
                            >
                                <span>Learn More About Us</span>
                                <span class="w-8 h-px bg-orange-500 group-hover:w-14 transition-all duration-300"></span>
                                <span class="text-base group-hover:translate-x-1 transition-transform">→</span>
                            </Link>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SERVICES PREVIEW (6 Core Clickable Services) -->
        <section id="services-section" class="py-28 lg:py-36 bg-[#0a0f1d] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div class="max-w-2xl space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-500/10 border border-orange-500/20 rounded-full">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Platform Capabilities</span>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                            Core Management Modules<span class="text-orange-500">.</span>
                        </h2>
                        <p class="text-slate-400 text-base leading-relaxed">
                            Comprehensive construction tools built for scale, reliability, and precision field execution.
                        </p>
                    </div>

                    <Link 
                        :href="route('services')"
                        class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-300 hover:text-orange-500 transition-colors self-start md:self-end"
                    >
                        <span>View All Capabilities</span>
                        <span>→</span>
                    </Link>
                </div>

                <!-- 6 Clickable Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <Link 
                        v-for="(service, idx) in displayServices.slice(0, 6)" 
                        :key="service.id || idx"
                        :href="route('services.show', service.slug || 'project-management')"
                        class="group p-8 lg:p-10 bg-[#060913] border border-white/[0.08] hover:border-orange-500/60 rounded-3xl transition-all duration-500 hover:-translate-y-2 flex flex-col justify-between relative overflow-hidden shadow-xl"
                    >
                        <div class="flex items-center justify-between mb-8">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-orange-400 transition-colors">
                                MODULE 0{{ idx + 1 }}
                            </span>
                            <div class="w-10 h-10 rounded-xl bg-white/[0.03] group-hover:bg-orange-500 text-slate-400 group-hover:text-black flex items-center justify-center transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getIconPath(service.icon, service.slug)"/>
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <h3 class="text-2xl font-black uppercase tracking-tight text-white group-hover:text-orange-500 transition-colors">
                                {{ service.title }}
                            </h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                {{ service.short_description }}
                            </p>
                        </div>

                        <div class="pt-6 border-t border-white/5 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-white">
                            <span>Explore Module</span>
                            <span class="text-orange-500 font-bold">→</span>
                        </div>

                        <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-orange-500 to-amber-500 group-hover:w-full transition-all duration-500"></div>
                    </Link>
                </div>

            </div>
        </section>

        <!-- 5. FEATURED PROJECTS SHOWCASE -->
        <section class="py-28 lg:py-36 bg-[#060913] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div class="max-w-2xl space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-full">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Verified Case Studies</span>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                            Featured Projects<span class="text-orange-500">.</span>
                        </h2>
                        <p class="text-slate-400 text-base leading-relaxed">
                            Selected high-performance developments engineered, budgeted, and managed through BrickBeam.
                        </p>
                    </div>

                    <Link 
                        :href="route('projects')"
                        class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-300 hover:text-orange-500 transition-colors self-start md:self-end"
                    >
                        <span>View Project Archive</span>
                        <span>→</span>
                    </Link>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-12">
                    <Link 
                        v-for="project in displayProjects.slice(0, 4)" 
                        :key="project.id || project.slug"
                        :href="route('projects.show', project.slug)"
                        class="group bg-[#0a0f1d] border border-white/[0.08] hover:border-orange-500/50 rounded-3xl overflow-hidden shadow-2xl transition-all duration-500 flex flex-col justify-between"
                    >
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-900">
                            <img 
                                :src="resolveImage(project.featured_image)" 
                                @error="($event) => $event.target.src = defaultHeroImg"
                                :alt="project.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-transparent to-transparent"></div>

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

                            <div class="absolute bottom-4 left-4">
                                <span class="text-xs font-bold text-slate-300 bg-black/70 backdrop-blur-md px-3 py-1 rounded-md border border-white/10">
                                    Budget: <span class="text-white font-black">{{ project.budget }}</span>
                                </span>
                            </div>
                        </div>

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

                            <div class="space-y-2 pt-4 border-t border-white/5">
                                <div class="flex justify-between text-xs font-bold uppercase tracking-wider">
                                    <span class="text-slate-400">Physical Milestone Completion</span>
                                    <span class="text-orange-500">{{ project.progress || 75 }}%</span>
                                </div>
                                <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                                    <div 
                                        class="h-full bg-gradient-to-r from-orange-500 to-amber-400 rounded-full transition-all duration-1000"
                                        :style="{ width: `${project.progress || 75}%` }"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-4 bg-white/[0.02] border-t border-white/5 flex items-center justify-between text-xs font-black uppercase tracking-wider text-orange-500 group-hover:text-white">
                            <span>Open Project Dossier</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </Link>
                </div>

            </div>
        </section>

        <!-- 6. WHY BRICKBEAM (5 Pillars) -->
        <section class="py-28 lg:py-36 bg-[#0a0f1d] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="max-w-3xl mb-16 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-950/60 border border-purple-500/30 rounded-full">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-purple-300">Platform Value</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                        Why BrickBeam?<span class="text-orange-500">.</span>
                    </h2>
                    <p class="text-slate-400 text-base sm:text-lg">
                        Five fundamental architectural advantages engineered to keep construction firms ahead of schedule and under budget.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(pillar, idx) in pillars" 
                        :key="idx"
                        class="p-8 lg:p-10 bg-[#050811] border border-white/[0.08] hover:border-purple-500/50 rounded-3xl transition-all duration-300 space-y-4 relative group hover:-translate-y-1 hover:shadow-2xl hover:shadow-purple-950/30"
                    >
                        <div class="text-3xl mb-2">{{ pillar.icon }}</div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-purple-400 group-hover:text-orange-400 transition-colors block">
                            ADVANTAGE 0{{ idx + 1 }}
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

        <!-- 7. CONSTRUCTION PROCESS (4 Phased Steps) -->
        <section class="py-28 lg:py-36 bg-[#050811] border-t border-white/[0.08] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-2xl mx-auto mb-20 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-950/60 border border-purple-500/30 rounded-full">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-purple-300">Execution Framework</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                        The BrickBeam Process<span class="text-orange-500">.</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base">
                        A structured four-phase digital workflow designed for modern contractors and developers.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                    <div 
                        v-for="(step, idx) in processes" 
                        :key="idx"
                        class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-6 hover:border-purple-500/50 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-orange-500">{{ step.step }}</span>
                            <span class="w-8 h-8 rounded-full bg-purple-950/80 border border-purple-800/40 flex items-center justify-center text-xs font-bold text-purple-300 group-hover:bg-orange-500 group-hover:text-black transition-colors">✓</span>
                        </div>
                        <div class="space-y-3">
                            <h3 class="text-lg font-black uppercase tracking-tight text-white group-hover:text-orange-400 transition-colors">
                                {{ step.title }}
                            </h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                {{ step.desc }}
                            </p>
                        </div>
                        <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-purple-600 to-orange-500 rounded-full w-0 group-hover:w-full transition-all duration-700"></div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 8. TESTIMONIALS SECTION -->
        <section class="py-28 lg:py-36 bg-[#0a0f1d] border-t border-white/[0.08] relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-950/60 border border-purple-500/30 rounded-full">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-purple-300">Industry Endorsement</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                        Trusted by Construction Leaders<span class="text-orange-500">.</span>
                    </h2>
                </div>

                <div class="max-w-4xl mx-auto">
                    <div class="p-8 sm:p-14 bg-[#050811] border border-purple-900/30 rounded-3xl shadow-2xl relative">
                        <div class="flex items-center gap-1 mb-6 text-amber-400">
                            <span v-for="s in (activeTestimonials[currentTestimonialIndex]?.rating || 5)" :key="s" class="text-lg">★</span>
                        </div>

                        <p class="text-lg sm:text-2xl text-slate-200 font-medium leading-relaxed mb-8 italic">
                            "{{ activeTestimonials[currentTestimonialIndex]?.testimonial }}"
                        </p>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-white/10">
                            <div>
                                <h4 class="text-base font-black text-white uppercase tracking-wide">
                                    {{ activeTestimonials[currentTestimonialIndex]?.client_name }}
                                </h4>
                                <p class="text-xs text-purple-400 font-bold uppercase tracking-wider">
                                    {{ activeTestimonials[currentTestimonialIndex]?.client_position }} — {{ activeTestimonials[currentTestimonialIndex]?.client_company }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <button 
                                    @click="prevTestimonial"
                                    class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500 flex items-center justify-center text-white transition-colors"
                                    aria-label="Previous testimonial"
                                >
                                    ←
                                </button>
                                <button 
                                    @click="nextTestimonial"
                                    class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500 flex items-center justify-center text-white transition-colors"
                                    aria-label="Next testimonial"
                                >
                                    →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 9. FAQ SECTION (Accordion) -->
        <section class="py-28 lg:py-36 bg-[#050811] border-t border-white/[0.08] relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center space-y-4 mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-950/60 border border-purple-500/30 rounded-full">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-purple-300">Questions & Answers</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                        Frequently Asked Questions<span class="text-orange-500">.</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base">
                        Everything you need to know about implementing BrickBeam across your construction projects.
                    </p>
                </div>

                <div class="space-y-4">
                    <div 
                        v-for="(faq, index) in (faqs?.length ? faqs : defaultFaqs)" 
                        :key="index"
                        class="border border-white/10 rounded-2xl bg-[#0a0f1d] overflow-hidden transition-colors duration-200"
                        :class="activeFaqIndex === index ? 'border-purple-500/50 shadow-lg shadow-purple-950/20' : 'hover:border-white/20'"
                    >
                        <button 
                            @click="toggleFaq(index)"
                            type="button"
                            class="w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-white uppercase text-sm tracking-wide focus:outline-none"
                        >
                            <span>{{ faq.question }}</span>
                            <span 
                                class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-orange-500 font-bold flex-shrink-0 transition-transform duration-300"
                                :class="activeFaqIndex === index ? 'rotate-180 bg-orange-500 text-black' : ''"
                            >
                                ↓
                            </span>
                        </button>

                        <div 
                            v-show="activeFaqIndex === index" 
                            class="px-6 pb-6 text-slate-400 text-sm leading-relaxed border-t border-white/5 pt-4"
                        >
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 10. CONVERSION CTA BANNER -->
        <section class="py-24 bg-gradient-to-br from-[#0a0f1d] via-[#1a0826] to-[#050811] border-t border-white/[0.08] text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-purple-600/10 backdrop-blur-3xl pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8">
                <span class="text-xs font-black text-orange-400 uppercase tracking-[0.3em] block">Ready to Build Smarter?</span>
                
                <h2 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white leading-tight">
                    Transform Your Construction Operations Today<span class="text-orange-500">.</span>
                </h2>

                <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                    Connect with our construction solutions engineers to configure BrickBeam for your active jobsites, teams, and project portfolio.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                    <Link 
                        :href="route('contact')"
                        class="px-10 py-5 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs rounded-xl shadow-2xl shadow-orange-500/30 transition-all duration-300"
                    >
                        Start Your Project Consultation
                    </Link>
                    <Link 
                        :href="route('services')"
                        class="px-10 py-5 bg-purple-950/60 hover:bg-purple-900 border border-purple-500/30 text-white font-black uppercase tracking-widest text-xs rounded-xl transition-all duration-300"
                    >
                        Explore Capabilities
                    </Link>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>
