<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

const page = usePage();
const settings = computed(() => page.props.settings || {});

const siteName = computed(() => settings.value?.site_name || 'BrickBeam');
const companyInfo = computed(() => settings.value?.company_info || 'Enterprise construction management platform engineered to centralize project planning, daily field ticketing, trade coordination, and real-time Earned Value budget telemetry.');
const contactEmail = computed(() => settings.value?.contact_email || 'info@brickbeam.com');
const contactPhone = computed(() => settings.value?.contact_phone || '+92 (51) 884-2900');

// Scroll state for navbar
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 30;
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
    { name: 'Overview', route: 'home', path: '/' },
    { name: 'Architecture', route: 'about', path: '/about' },
    { name: 'Capabilities', route: 'services', path: '/services' },
    { name: 'Projects', route: 'projects', path: '/projects' },
    { name: 'Contact', route: 'contact', path: '/contact' },
];

const isCurrentRoute = (path) => {
    const url = page.url || '';
    if (path === '/') return url === '/' || url === '';
    if (path === '/projects') return url.startsWith('/projects') || url.startsWith('/portfolio');
    if (path === '/services') return url.startsWith('/services');
    if (path === '/about') return url.startsWith('/about');
    if (path === '/contact') return url.startsWith('/contact');
    return url.startsWith(path);
};

// Footer Compact Expandable FAQs
const footerFaqOpen = ref(null);
const toggleFooterFaq = (idx) => {
    footerFaqOpen.value = footerFaqOpen.value === idx ? null : idx;
};

const footerFaqs = [
    {
        q: 'What is BrickBeam Construction Management Platform?',
        a: 'BrickBeam is an institutional-grade construction management system unifying project timelines, trade dispatch, Earned Value cost telemetry, and 4D digital twin orchestration.'
    },
    {
        q: 'How does BrickBeam control project budgets and avoid cost overruns?',
        a: 'We monitor Cost Performance Index (CPI) and Schedule Performance Index (SPI) in real time with automated 3-way invoice matching and automated variance alerts.'
    },
    {
        q: 'Can multiple contractors and engineering disciplines collaborate?',
        a: 'Yes. BrickBeam features multi-tier role-based access control for General Contractors, Subcontractors, Architects, Field Engineers, and Project Owners.'
    },
    {
        q: 'Is BrickBeam suitable for both large infrastructure and boutique projects?',
        a: 'Yes. The modular architecture scales from multi-tower residential developments and commercial high-rises to focused structural renovations.'
    }
];
</script>

<template>
    <div class="min-h-screen bg-[#0D0D0D] text-[#F3F1EC] font-sans flex flex-col justify-between selection:bg-[#E05A1B] selection:text-[#0D0D0D]">
        
        <!-- Global Architectural Sticky Navbar -->
        <header 
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="[
                isScrolled 
                    ? 'bg-[#0D0D0D]/95 backdrop-blur-md border-b border-[#242424] py-3.5 shadow-2xl shadow-black/90' 
                    : 'bg-gradient-to-b from-[#0D0D0D] via-[#0D0D0D]/85 to-transparent py-5 border-b border-white/[0.04]'
            ]"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    
                    <!-- Brand Identity & Architectural Logo -->
                    <Link :href="route('home')" class="flex items-center gap-3.5 group">
                        <!-- Structural Beam Geometric Mark -->
                        <div class="w-10 h-10 bg-[#171717] border border-[#242424] group-hover:border-[#E05A1B] rounded-xl flex items-center justify-center transition-all duration-300 relative overflow-hidden shadow-inner">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#E05A1B]/15 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="w-5 h-5 text-[#E05A1B] transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <line x1="3" y1="9" x2="21" y2="9" />
                                <line x1="9" y1="21" x2="9" y2="9" />
                                <line x1="15" y1="21" x2="15" y2="9" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-display text-xl font-extrabold tracking-tight text-white flex items-center gap-1 leading-none">
                                BRICK<span class="text-[#E05A1B]">BEAM</span>
                            </span>
                            <span class="industrial-badge text-[8px] text-[#A3A3A3] mt-1 tracking-[0.25em]">
                                SYSTEM PLATFORM
                            </span>
                        </div>
                    </Link>

                    <!-- Desktop Clean Centered Navigation Bar -->
                    <nav class="hidden lg:flex items-center gap-1.5 bg-[#171717]/90 border border-[#242424] px-3 py-1.5 rounded-xl backdrop-blur-md shadow-lg">
                        <Link 
                            v-for="link in navLinks" 
                            :key="link.name"
                            :href="route(link.route)"
                            class="px-4 py-1.5 text-xs font-semibold tracking-wider rounded-lg transition-all duration-200 uppercase font-display"
                            :class="[
                                isCurrentRoute(link.path)
                                    ? 'text-white bg-[#242424] border border-[#383838] shadow-sm'
                                    : 'text-[#A3A3A3] hover:text-white hover:bg-white/[0.05]'
                            ]"
                        >
                            {{ link.name }}
                        </Link>
                    </nav>

                    <!-- Right Quick Action -->
                    <div class="hidden sm:flex items-center gap-3">
                        <Link 
                            :href="route('contact')"
                            class="px-4 py-2 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] font-display text-xs font-bold uppercase tracking-wider rounded-lg transition-all shadow-md shadow-[#E05A1B]/20"
                        >
                            Contact Engineering
                        </Link>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex lg:hidden items-center">
                        <button 
                            @click="isMobileMenuOpen = !isMobileMenuOpen"
                            type="button" 
                            class="p-2 rounded-xl bg-[#171717] border border-[#242424] text-[#A3A3A3] hover:text-white transition-colors"
                            aria-label="Toggle navigation menu"
                        >
                            <svg v-if="!isMobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div v-if="isMobileMenuOpen" class="lg:hidden bg-[#171717] border-b border-[#242424] px-4 pt-4 pb-6 mt-3 space-y-2 shadow-2xl">
                    <Link 
                        v-for="link in navLinks" 
                        :key="link.name"
                        :href="route(link.route)"
                        @click="isMobileMenuOpen = false"
                        class="block px-4 py-2.5 rounded-lg text-xs font-display font-bold uppercase tracking-wider transition-colors"
                        :class="[
                            isCurrentRoute(link.path)
                                ? 'text-white bg-[#242424] border border-[#383838]'
                                : 'text-[#A3A3A3] hover:text-white hover:bg-white/[0.04]'
                        ]"
                    >
                        {{ link.name }}
                    </Link>
                </div>
            </transition>
        </header>

        <!-- Main Content Viewport -->
        <main class="flex-1 w-full bg-[#0D0D0D]">
            <slot />
        </main>

        <!-- Premium Industrial Architectural Footer -->
        <footer class="bg-[#0A0A0A] text-[#F3F1EC] pt-20 pb-12 border-t border-[#242424] relative overflow-hidden">
            <!-- Subtle CAD Grid Overlay -->
            <div class="absolute inset-0 cad-grid opacity-30 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-16">
                
                <!-- 1. Expandable Frequently Answered Questions Accordion in Footer -->
                <div class="bg-[#111111] border border-[#242424] rounded-2xl p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#242424]">
                        <div>
                            <span class="industrial-badge text-[#E05A1B] text-[9px] block">SYSTEM INQUIRIES & KNOWLEDGEBASE</span>
                            <h3 class="font-display text-xl sm:text-2xl font-bold text-white uppercase tracking-tight mt-1">
                                Frequently Asked Questions<span class="text-[#E05A1B]">.</span>
                            </h3>
                        </div>
                        <Link 
                            :href="route('faqs')" 
                            class="inline-flex items-center text-xs font-mono text-[#A3A3A3] hover:text-[#E05A1B] transition-colors gap-1.5"
                        >
                            <span>View Full FAQ Directory</span>
                            <span>→</span>
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6">
                        <div 
                            v-for="(faq, fIdx) in footerFaqs" 
                            :key="fIdx"
                            class="bg-[#171717] border border-[#242424] rounded-xl overflow-hidden transition-all duration-200"
                            :class="footerFaqOpen === fIdx ? 'border-[#E05A1B]/50' : 'hover:border-[#383838]'"
                        >
                            <button 
                                @click="toggleFooterFaq(fIdx)"
                                type="button"
                                class="w-full p-4 text-left flex items-center justify-between gap-3 text-xs sm:text-sm font-display font-bold uppercase tracking-tight text-white"
                            >
                                <span>{{ faq.q }}</span>
                                <span 
                                    class="w-6 h-6 rounded-md bg-[#242424] text-[#E05A1B] flex items-center justify-center font-bold text-xs flex-shrink-0 transition-transform duration-200"
                                    :class="footerFaqOpen === fIdx ? 'rotate-45' : ''"
                                >
                                    +
                                </span>
                            </button>
                            <div 
                                v-if="footerFaqOpen === fIdx"
                                class="px-4 pb-4 text-xs text-[#A3A3A3] leading-relaxed border-t border-[#242424] pt-3"
                            >
                                {{ faq.a }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Navigation Columns Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-10 pb-16 border-b border-[#242424]">
                    
                    <!-- Column 1: Brand & Narrative -->
                    <div class="lg:col-span-2 space-y-6">
                        <Link :href="route('home')" class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-[#171717] border border-[#242424] rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#E05A1B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <line x1="3" y1="9" x2="21" y2="9" />
                                    <line x1="9" y1="21" x2="9" y2="9" />
                                    <line x1="15" y1="21" x2="15" y2="9" />
                                </svg>
                            </div>
                            <span class="font-display text-xl font-bold text-white tracking-tight">BRICK<span class="text-[#E05A1B]">BEAM</span></span>
                        </Link>
                        
                        <p class="text-[#A3A3A3] text-sm leading-relaxed max-w-md">
                            {{ companyInfo }}
                        </p>

                        <!-- Verified Contact Nodes -->
                        <div class="space-y-3 pt-2">
                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="industrial-badge px-2.5 py-1 bg-[#171717] border border-[#242424] text-[#A3A3A3] rounded">📍 ISLAMABAD HQ</span>
                                <span class="industrial-badge px-2.5 py-1 bg-[#171717] border border-[#242424] text-[#A3A3A3] rounded">📍 LAHORE HUB</span>
                                <span class="industrial-badge px-2.5 py-1 bg-[#171717] border border-[#242424] text-[#A3A3A3] rounded">📍 KARACHI OPS</span>
                            </div>
                            <div class="flex items-center gap-4 pt-1">
                                <div class="p-3 bg-[#171717] border border-[#242424] rounded-xl">
                                    <span class="industrial-badge text-[#E05A1B] block">Direct Hotline</span>
                                    <a :href="'tel:' + contactPhone" class="text-xs font-semibold text-white hover:text-[#E05A1B] transition-colors">{{ contactPhone }}</a>
                                </div>
                                <div class="p-3 bg-[#171717] border border-[#242424] rounded-xl">
                                    <span class="industrial-badge text-[#E05A1B] block">Inquiries</span>
                                    <a :href="'mailto:' + contactEmail" class="text-xs font-semibold text-white hover:text-[#E05A1B] transition-colors">{{ contactEmail }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: System Modules -->
                    <div class="space-y-4">
                        <h4 class="font-display text-xs font-bold uppercase tracking-[0.2em] text-[#E05A1B]">System</h4>
                        <ul class="space-y-2.5 text-xs font-medium">
                            <li><Link :href="route('home')" class="text-[#A3A3A3] hover:text-white transition-colors">Overview</Link></li>
                            <li><Link :href="route('about')" class="text-[#A3A3A3] hover:text-white transition-colors">Architecture</Link></li>
                            <li><Link :href="route('services')" class="text-[#A3A3A3] hover:text-white transition-colors">Capabilities</Link></li>
                            <li><Link :href="route('projects')" class="text-[#A3A3A3] hover:text-white transition-colors">Project Portfolio</Link></li>
                            <li><Link :href="route('faqs')" class="text-[#A3A3A3] hover:text-white transition-colors">FAQ Directory</Link></li>
                            <li><Link :href="route('contact')" class="text-[#A3A3A3] hover:text-white transition-colors">Contact Engineering</Link></li>
                        </ul>
                    </div>

                    <!-- Column 3: Capabilities -->
                    <div class="space-y-4">
                        <h4 class="font-display text-xs font-bold uppercase tracking-[0.2em] text-[#E05A1B]">Capabilities</h4>
                        <ul class="space-y-2.5 text-xs font-medium">
                            <li><Link :href="route('services.show', 'custom-building')" class="text-[#A3A3A3] hover:text-white transition-colors">Custom Building</Link></li>
                            <li><Link :href="route('services.show', 'commercial-renovation')" class="text-[#A3A3A3] hover:text-white transition-colors">Commercial Renovation</Link></li>
                            <li><Link :href="route('services.show', 'quality-renovation')" class="text-[#A3A3A3] hover:text-white transition-colors">Quality Renovation</Link></li>
                            <li><Link :href="route('services.show', 'structural-design')" class="text-[#A3A3A3] hover:text-white transition-colors">Structural Design</Link></li>
                            <li><Link :href="route('services')" class="text-[#A3A3A3] hover:text-white transition-colors">All Capabilities & Estimator</Link></li>
                        </ul>
                    </div>

                    <!-- Column 4: Newsletter & Intelligence -->
                    <div class="space-y-4">
                        <h4 class="font-display text-xs font-bold uppercase tracking-[0.2em] text-[#E05A1B]">Intelligence</h4>
                        <p class="text-xs text-[#A3A3A3] leading-relaxed">
                            Subscribe to BrickBeam structural bulletins, EVM insights, and jobsite whitepapers.
                        </p>
                        
                        <form @submit.prevent="submitNewsletter" class="space-y-2 pt-1">
                            <div class="relative">
                                <input 
                                    v-model="newsletterForm.email" 
                                    type="email" 
                                    placeholder="engineering@firm.com" 
                                    required 
                                    class="w-full bg-[#171717] border border-[#242424] rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-[#525252] focus:outline-none focus:border-[#E05A1B] transition-all pr-10"
                                >
                                <button 
                                    type="submit" 
                                    :disabled="newsletterForm.processing"
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2 p-1.5 bg-[#E05A1B] text-[#0D0D0D] hover:bg-white rounded-lg transition-colors disabled:opacity-50"
                                    aria-label="Subscribe"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                            <p v-if="isSubscribed" class="text-[11px] text-[#E5A93C] font-semibold">
                                ✓ Subscribed to BrickBeam intelligence.
                            </p>
                        </form>
                    </div>

                </div>

                <!-- 3. Bottom Industrial Metadata & Legal Links -->
                <div class="pt-2 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-[#525252]">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-[#E05A1B] animate-pulse"></span>
                        <p>© {{ new Date().getFullYear() }} {{ siteName }} Construction Management System. All rights reserved.</p>
                    </div>
                    <div class="flex items-center gap-5 industrial-badge text-[10px] text-[#A3A3A3]">
                        <Link :href="route('privacy-policy')" class="hover:text-white transition-colors">Privacy Policy</Link>
                        <span>|</span>
                        <Link :href="route('terms-and-conditions')" class="hover:text-white transition-colors">Terms & Conditions</Link>
                        <span>|</span>
                        <Link :href="route('about')" class="hover:text-white transition-colors">Architecture</Link>
                        <span>|</span>
                        <Link :href="route('contact')" class="hover:text-white transition-colors">Contact</Link>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>
