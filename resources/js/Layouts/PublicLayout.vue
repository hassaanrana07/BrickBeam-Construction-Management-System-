<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

const page = usePage();
const settings = computed(() => page.props.settings || {});

const siteName = computed(() => settings.value?.site_name || 'BrickBeam');
const companyInfo = computed(() => settings.value?.company_info || 'Enterprise construction management platform engineered to keep projects, teams, tasks, budgets, and progress organized in one unified system.');
const contactEmail = computed(() => settings.value?.contact_email || 'info@brickbeam.com');
const contactPhone = computed(() => settings.value?.contact_phone || '+92 (51) 884-2900');

// Scroll state for navbar
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 40;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

// Newsletter
const newsletterForm = useForm({
    email: ''
});

const isSubscribed = ref(false);

const submitNewsletter = () => {
    if (!newsletterForm.email) return;
    newsletterForm.post(route('newsletter.subscribe'), {
        preserveScroll: true,
        onSuccess: () => {
            newsletterForm.reset();
            isSubscribed.value = true;
            setTimeout(() => { isSubscribed.value = false; }, 5000);
        },
        onError: () => {
            // optimistic fallback
            isSubscribed.value = true;
            setTimeout(() => { isSubscribed.value = false; }, 5000);
        }
    });
};

const navLinks = [
    { name: 'Home', route: 'home', path: '/' },
    { name: 'About', route: 'about', path: '/about' },
    { name: 'Services', route: 'services', path: '/services' },
    { name: 'Projects', route: 'projects', path: '/projects' },
    { name: 'Contact', route: 'contact', path: '/contact' },
];

const isCurrentRoute = (path) => {
    const url = page.url || '';
    if (path === '/') return url === '/' || url === '';
    if (path === '/projects') return url.startsWith('/projects') || url.startsWith('/portfolio');
    return url.startsWith(path);
};
</script>

<template>
    <div class="min-h-screen bg-[#050811] text-slate-100 font-sans selection:bg-orange-500 selection:text-black flex flex-col justify-between">
        
        <!-- Global Sticky Navbar -->
        <header 
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="[
                isScrolled 
                    ? 'bg-[#050811]/90 backdrop-blur-xl border-b border-purple-900/30 py-3.5 shadow-2xl shadow-black/80' 
                    : 'bg-gradient-to-b from-[#050811]/90 via-[#050811]/50 to-transparent py-5'
            ]"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    
                    <!-- Brand Logo -->
                    <Link :href="route('home')" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 via-purple-700 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-900/40 group-hover:scale-105 transition-transform duration-300">
                            <!-- Architectural Beam Icon -->
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <path d="M3 9h18" />
                                <path d="M9 21V9" />
                                <path d="M15 21V9" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-extrabold tracking-tight text-white flex items-center gap-1">
                                BRICK<span class="text-orange-500">BEAM</span>
                            </span>
                            <span class="text-[9px] font-bold tracking-[0.25em] text-purple-300 uppercase leading-none">
                                Construction Platform
                            </span>
                        </div>
                    </Link>

                    <!-- Desktop Navigation Links -->
                    <nav class="hidden md:flex items-center gap-1 lg:gap-2 bg-white/[0.03] border border-white/[0.08] px-3 py-1.5 rounded-full backdrop-blur-md">
                        <Link 
                            v-for="link in navLinks" 
                            :key="link.name"
                            :href="route(link.route)"
                            class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-200"
                            :class="[
                                isCurrentRoute(link.path)
                                    ? 'text-white bg-gradient-to-r from-purple-700 to-orange-500 shadow-md shadow-purple-900/30'
                                    : 'text-slate-300 hover:text-white hover:bg-white/[0.06]'
                            ]"
                        >
                            {{ link.name }}
                        </Link>
                    </nav>

                    <!-- Right CTA and Actions -->
                    <div class="hidden md:flex items-center gap-4">
                        <Link 
                            :href="route('contact')" 
                            class="relative group inline-flex items-center justify-center px-5 py-2.5 text-xs font-black uppercase tracking-wider text-black bg-orange-500 hover:bg-white rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-white/20 transition-all duration-300"
                        >
                            <span>Start a Project</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </Link>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex md:hidden items-center">
                        <button 
                            @click="isMobileMenuOpen = !isMobileMenuOpen"
                            type="button" 
                            class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 hover:text-white hover:bg-white/10 transition-colors"
                            aria-label="Toggle navigation menu"
                        >
                            <svg v-if="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <div v-if="isMobileMenuOpen" class="md:hidden bg-[#070a14] border-b border-purple-900/30 px-4 pt-4 pb-6 mt-3 space-y-3 shadow-2xl">
                    <Link 
                        v-for="link in navLinks" 
                        :key="link.name"
                        :href="route(link.route)"
                        @click="isMobileMenuOpen = false"
                        class="block px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider transition-colors"
                        :class="[
                            isCurrentRoute(link.path)
                                ? 'text-white bg-gradient-to-r from-purple-700 to-orange-500'
                                : 'text-slate-300 hover:text-white hover:bg-white/5'
                        ]"
                    >
                        {{ link.name }}
                    </Link>
                    <div class="pt-3 border-t border-white/10">
                        <Link 
                            :href="route('contact')"
                            @click="isMobileMenuOpen = false"
                            class="block w-full py-3.5 text-center text-xs font-black uppercase tracking-widest text-black bg-orange-500 hover:bg-white rounded-xl shadow-lg transition-colors"
                        >
                            Start a Project
                        </Link>
                    </div>
                </div>
            </transition>
        </header>

        <!-- Main Content -->
        <main class="flex-1 w-full">
            <slot />
        </main>

        <!-- Premium Global Footer -->
        <footer class="bg-[#03050a] text-white pt-24 pb-12 border-t border-white/[0.08] relative overflow-hidden">
            <!-- Subtle background accent glow -->
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-10 pb-16 border-b border-white/[0.08]">
                    
                    <!-- Column 1: Brand & Narrative -->
                    <div class="lg:col-span-2 space-y-6">
                        <Link :href="route('home')" class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-900/30">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <path d="M3 9h18" />
                                    <path d="M9 21V9" />
                                    <path d="M15 21V9" />
                                </svg>
                            </div>
                            <span class="text-2xl font-black text-white tracking-tight">BRICK<span class="text-orange-500">BEAM</span></span>
                        </Link>
                        
                        <p class="text-slate-400 text-sm leading-relaxed max-w-md">
                            {{ companyInfo }}
                        </p>

                        <!-- Verified Contact Nodes -->
                        <div class="space-y-3 pt-2">
                            <div class="flex flex-wrap gap-2 text-xs font-bold">
                                <span class="px-3 py-1 bg-purple-950/60 border border-purple-800/40 text-purple-300 rounded-lg">📍 Lahore, Pakistan</span>
                                <span class="px-3 py-1 bg-purple-950/60 border border-purple-800/40 text-purple-300 rounded-lg">📍 Islamabad, Pakistan</span>
                                <span class="px-3 py-1 bg-purple-950/60 border border-purple-800/40 text-purple-300 rounded-lg">📍 Rajiv</span>
                            </div>
                            <div class="flex items-center gap-4 pt-1">
                                <div class="p-3 bg-white/5 border border-white/10 rounded-xl">
                                    <span class="text-[10px] font-black uppercase text-orange-400 tracking-widest block">Hotline</span>
                                    <a :href="'tel:' + contactPhone" class="text-sm font-bold text-white hover:text-orange-400 transition-colors">{{ contactPhone }}</a>
                                </div>
                                <div class="p-3 bg-white/5 border border-white/10 rounded-xl">
                                    <span class="text-[10px] font-black uppercase text-orange-400 tracking-widest block">Email</span>
                                    <a :href="'mailto:' + contactEmail" class="text-sm font-bold text-white hover:text-orange-400 transition-colors">{{ contactEmail }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Company -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-black uppercase tracking-[0.25em] text-orange-400">Company</h4>
                        <ul class="space-y-3">
                            <li><Link :href="route('home')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Home</Link></li>
                            <li><Link :href="route('about')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">About BrickBeam</Link></li>
                            <li><Link :href="route('services')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Core Services</Link></li>
                            <li><Link :href="route('projects')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Project Showcase</Link></li>
                            <li><Link :href="route('contact')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Contact & Locations</Link></li>
                        </ul>
                    </div>

                    <!-- Column 3: Services Modules -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-black uppercase tracking-[0.25em] text-orange-400">Services</h4>
                        <ul class="space-y-3">
                            <li><Link :href="route('services.show', 'project-management')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Project Management</Link></li>
                            <li><Link :href="route('services.show', 'task-management')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Task Management</Link></li>
                            <li><Link :href="route('services.show', 'team-management')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Team Management</Link></li>
                            <li><Link :href="route('services.show', 'budget-management')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Budget Management</Link></li>
                            <li><Link :href="route('services.show', 'progress-tracking')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Progress Tracking</Link></li>
                            <li><Link :href="route('services.show', 'reports-analytics')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Reports & Analytics</Link></li>
                        </ul>
                    </div>

                    <!-- Column 4: Stay Updated & Legal -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-black uppercase tracking-[0.25em] text-orange-400">Legal & Updates</h4>
                        <ul class="space-y-3 mb-4">
                            <li><Link :href="route('privacy-policy')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Privacy Policy</Link></li>
                            <li><Link :href="route('terms-and-conditions')" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Terms & Conditions</Link></li>
                        </ul>
                        
                        <form @submit.prevent="submitNewsletter" class="space-y-2 pt-2">
                            <div class="relative">
                                <input 
                                    v-model="newsletterForm.email" 
                                    type="email" 
                                    placeholder="Corporate email..." 
                                    required 
                                    class="w-full bg-white/[0.04] border border-white/10 rounded-xl px-4 py-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all pr-10"
                                >
                                <button 
                                    type="submit" 
                                    :disabled="newsletterForm.processing"
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2 p-2 bg-orange-500 text-black hover:bg-white rounded-lg transition-colors disabled:opacity-50"
                                    aria-label="Subscribe"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                            <p v-if="isSubscribed" class="text-[11px] text-green-400 font-semibold">
                                ✓ Subscribed to BrickBeam intelligence.
                            </p>
                        </form>
                    </div>

                </div>

                <!-- Bottom Bar -->
                <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                    <p>© {{ new Date().getFullYear() }} {{ siteName }} Construction Management System. All rights reserved.</p>
                    <div class="flex items-center gap-6 text-[11px] font-semibold uppercase tracking-wider">
                        <Link :href="route('privacy-policy')" class="hover:text-slate-300 transition-colors">Privacy Policy</Link>
                        <span>•</span>
                        <Link :href="route('terms-and-conditions')" class="hover:text-slate-300 transition-colors">Terms & Conditions</Link>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>

