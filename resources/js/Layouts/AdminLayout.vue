<script setup>
import { ref, onMounted, computed, provide } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;
const settings = computed(() => page.props.settings || {});
const companyLogo = computed(() => settings.value?.company_logo || null);
const siteName = computed(() => settings.value?.site_name || 'Brick & Beam');
const headerStyle = computed(() => settings.value?.header_style || 'logo_and_name');
const showCompanyName = computed(() => settings.value?.show_company_name ?? true);

const sidebarOpen = ref(true);
const userDropdownOpen = ref(false);

const isDark = ref(true);
provide('isDark', isDark);

const permissions = user.permissions || [];
const roles = user.roles || [];
const hasRole = (...roleNames) => roleNames.some(r => roles.includes(r));
const hasPermission = (permission) => permissions.includes(permission);
const isSuperAdmin = hasRole('Super Admin', 'super-admin', 'superadmin');

const ICONS = {
    dashboard:    'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    users:        'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
    finance:      'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    leads:        'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
    portfolio:    'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
    tasks:        'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
    staff:        'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
    blog:         'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
    pages:        'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z',
    audit:        'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
    settings:     'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
    expenses:     'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
    vendors:      'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
    inquiries:    'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
    announcements:'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z',
    milestones:   'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
    services:     'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
    purchase:     'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
    testimonials: 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
    faqs:         'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    metrics:      'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
    revenue:      'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    estimate:     'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
    certifications:'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M3 9a9 9 0 0018 0V9a9 9 0 00-18 0zm6 12l-2-2 2-2m6 0l2 2-2 2',
};

const navigation = computed(() => {
    const nav = [
        { name: 'Command Dashboard', href: route('admin.dashboard'), icon: ICONS.dashboard },
    ];

    if (isSuperAdmin) {
        nav.push({ name: 'System Metrics', href: route('admin.system-metrics'), icon: ICONS.metrics });
        nav.push({ name: 'Financial Ledger', href: route('admin.finance.index'), icon: ICONS.revenue });
    }

    if (hasPermission('manage users') || isSuperAdmin) {
        nav.push({ name: 'Access Matrix', href: route('admin.users.index'), icon: ICONS.users });
    }

    if (hasPermission('manage portfolios') || isSuperAdmin || hasRole('Admin Manager', 'Manager', 'Finance Manager')) {
        nav.push({ name: 'Project Portfolio', href: route('admin.portfolios.index'), icon: ICONS.portfolio });
    }

    if (hasPermission('manage tasks') || isSuperAdmin || hasRole('Admin Manager', 'Manager', 'Staff', 'Editor (Staff)', 'Finance Manager')) {
        nav.push({ name: 'Task Board', href: route('admin.tasks.index'), icon: ICONS.tasks });
    }

    if (hasPermission('manage staff') || isSuperAdmin || hasRole('Admin Manager', 'Manager')) {
        nav.push({ name: 'Personnel Matrix', href: route('admin.staff.index'), icon: ICONS.staff });
    }

    if (hasPermission('view finances') || isSuperAdmin || hasRole('Finance Manager', 'Finance Support', 'Financial Support', 'Admin Manager', 'Manager')) {
        nav.push({ name: 'Revenue', href: route('admin.revenue.index'), icon: ICONS.revenue });
        nav.push({ name: 'Expenses', href: route('admin.expenses.index'), icon: ICONS.expenses });
    }

    if (hasPermission('manage leads') || isSuperAdmin || hasRole('Support', 'Admin Manager', 'Manager')) {
        nav.push({ name: 'Leads', href: route('admin.leads.index'), icon: ICONS.leads });
    }

    if (isSuperAdmin || hasRole('Support', 'Admin Manager', 'Manager', 'Editor (Staff)')) {
        nav.push({ name: 'Inquiries', href: route('admin.inquiries.index'), icon: ICONS.inquiries });
    }

    if (hasPermission('manage blog') || isSuperAdmin || hasRole('Editor (Staff)', 'Admin Manager', 'Manager')) {
        nav.push({ name: 'Insights & Blog', href: route('admin.blog.index'), icon: ICONS.blog });
        nav.push({ name: 'Testimonials', href: route('admin.testimonials.index'), icon: ICONS.testimonials });
        nav.push({ name: 'FAQs', href: route('admin.faqs.index'), icon: ICONS.faqs });
    }

    if (isSuperAdmin || hasRole('Admin Manager', 'Manager', 'Editor (Staff)')) {
        nav.push({ name: 'Services', href: route('admin.services.index'), icon: ICONS.services });
    }

    if (hasPermission('manage pages') || isSuperAdmin) {
        nav.push({ name: 'Site Pages', href: route('admin.pages.index'), icon: ICONS.pages });
    }

    if (hasPermission('manage audit logs') || isSuperAdmin) {
        nav.push({ name: 'Audit Logs', href: route('admin.audit-logs.index'), icon: ICONS.audit });
    }

    if (hasPermission('manage settings') || isSuperAdmin) {
        nav.push({ name: 'Settings', href: route('admin.settings.index'), icon: ICONS.settings });
    }

    return nav;
});

const filteredNavigation = navigation;

const isItemActive = (itemHref) => {
    try {
        const currentUrl = page.url.split('?')[0];
        const targetUrl = new URL(itemHref, window.location.origin).pathname;
        if (targetUrl === '/admin/dashboard' || targetUrl === '/admin') {
            return currentUrl === '/admin/dashboard' || currentUrl === '/admin';
        }
        return currentUrl === targetUrl || currentUrl.startsWith(targetUrl + '/');
    } catch {
        return false;
    }
};

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
    localStorage.setItem('sidebarState', sidebarOpen.value);
};

const logout = () => {
    router.post(route('logout'));
};

const globalSearchQuery = ref('');
const isGlobalSearchFocused = ref(false);

const performGlobalSearch = () => {
    if (!globalSearchQuery.value) return;
    router.get(route('admin.search'), { search: globalSearchQuery.value });
};

onMounted(() => {
    const savedState = localStorage.getItem('sidebarState');
    if (savedState !== null) {
        sidebarOpen.value = savedState === 'true';
    }
});
</script>

<template>
    <div class="min-h-screen bg-[#0D0D0D] text-[#F3F1EC] flex font-sans selection:bg-[#E05A1B] selection:text-[#0D0D0D]">
        <!-- Sidebar -->
        <aside :class="[sidebarOpen ? 'w-72' : 'w-20', 'bg-[#141414] text-[#A3A3A3] transition-all duration-300 flex flex-col fixed inset-y-0 z-50 border-r border-[#242424] shadow-2xl overflow-visible']">
            <!-- Branding Header -->
            <div class="h-16 flex items-center px-4 border-b border-[#242424] relative">
                <Link :href="route('admin.dashboard')" class="flex items-center gap-3 overflow-hidden flex-1 min-w-0 px-2 group">
                    <div class="w-9 h-9 bg-[#171717] border border-[#242424] group-hover:border-[#E05A1B] rounded-lg flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-5 h-5 text-[#E05A1B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <line x1="3" y1="9" x2="21" y2="9" />
                            <line x1="9" y1="21" x2="9" y2="9" />
                            <line x1="15" y1="21" x2="15" y2="9" />
                        </svg>
                    </div>
                    <div v-if="sidebarOpen" class="flex flex-col">
                        <span class="font-display text-sm font-bold tracking-tight text-white uppercase whitespace-nowrap">
                            BRICK<span class="text-[#E05A1B]">BEAM</span>
                        </span>
                        <span class="industrial-badge text-[8px] text-[#525252]">CONTROL TERMINAL</span>
                    </div>
                </Link>

                <!-- Sidebar Toggle -->
                <button @click="toggleSidebar" class="w-7 h-7 rounded-lg bg-[#171717] border border-[#242424] text-[#A3A3A3] hover:text-white hover:border-[#E05A1B] flex items-center justify-center transition-all absolute -right-3.5 top-1/2 -translate-y-1/2 shadow-xl z-50">
                    <svg :class="{'rotate-180': !sidebarOpen}" class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 py-4 space-y-1 overflow-y-auto custom-scrollbar px-2">
                <Link 
                    v-for="item in filteredNavigation" 
                    :key="item.name" 
                    :href="item.href" 
                    :class="[
                        isItemActive(item.href)
                            ? 'bg-[#242424] text-white font-bold border-l-4 border-[#E05A1B] shadow-sm' 
                            : 'text-[#A3A3A3] hover:text-white hover:bg-white/[0.03] border-l-4 border-transparent', 
                        'flex items-center px-3 py-2.5 rounded-r-lg transition-all text-xs font-display uppercase tracking-wider group'
                    ]"
                >
                    <svg :class="isItemActive(item.href) ? 'text-[#E05A1B]' : 'text-[#737373] group-hover:text-white'" class="w-4 h-4 min-w-[1rem] transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path :d="item.icon" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="ml-3 whitespace-nowrap text-[11px]" v-if="sidebarOpen">{{ item.name }}</span>
                    <span v-if="isItemActive(item.href) && sidebarOpen" class="ml-auto w-1.5 h-1.5 rounded-full bg-[#E05A1B]"></span>
                </Link>
            </nav>

            <!-- Sidebar Footer: Session Actions -->
            <div class="p-3 border-t border-[#242424] bg-[#111111]">
                <button @click="logout" class="w-full bg-[#171717] hover:bg-[#242424] border border-[#242424] hover:border-red-500/50 py-2.5 px-3 rounded-lg flex items-center justify-center gap-2 text-xs font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span v-if="sidebarOpen">Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main :class="[sidebarOpen ? 'pl-72' : 'pl-20', 'flex-1 transition-all duration-300 min-h-screen flex flex-col bg-[#0D0D0D]']">
            <!-- Top App Bar -->
            <header class="h-16 bg-[#141414]/90 backdrop-blur-md border-b border-[#242424] flex items-center justify-between px-6 sticky top-0 z-40">
                <div class="flex items-center gap-4 w-full max-w-lg">
                    <!-- Global Search -->
                    <div class="relative w-full">
                        <input 
                            v-model="globalSearchQuery"
                            @keyup.enter="performGlobalSearch"
                            type="text" 
                            placeholder="SEARCH SITES, TASKS, LEDGERS..." 
                            class="w-full bg-[#171717] border border-[#242424] text-white text-xs font-mono px-9 py-2 focus:border-[#E05A1B] focus:ring-0 rounded-lg placeholder-[#525252]"
                        >
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#525252]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Link to Public Website -->
                    <Link :href="route('home')" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#171717] border border-[#242424] hover:border-[#525252] rounded-lg text-[11px] font-display font-semibold uppercase tracking-wider text-[#A3A3A3] hover:text-white transition-colors">
                        <span>Live Site</span>
                        <span>↗</span>
                    </Link>

                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button @click="userDropdownOpen = !userDropdownOpen" class="flex items-center gap-3 p-1.5 pr-3 bg-[#171717] border border-[#242424] rounded-lg hover:border-[#525252] transition-colors">
                            <div class="w-7 h-7 bg-[#E05A1B] text-[#0D0D0D] font-bold text-xs flex items-center justify-center rounded">
                                {{ user.name.charAt(0) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-xs font-display font-bold text-white uppercase leading-none">{{ user.name }}</p>
                                <p class="text-[9px] font-mono text-[#E5A93C] mt-0.5">{{ user.roles?.[0] || 'Admin' }}</p>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div v-if="userDropdownOpen" class="absolute right-0 top-full mt-2 w-56 bg-[#171717] border border-[#242424] rounded-xl shadow-2xl p-1.5 z-50">
                            <Link :href="route('profile.edit')" class="block px-3 py-2 text-xs font-display font-semibold uppercase tracking-wider text-[#A3A3A3] hover:text-white hover:bg-[#242424] rounded-lg transition-colors">
                                Operator Profile
                            </Link>
                            <Link :href="route('home')" target="_blank" class="block px-3 py-2 text-xs font-display font-semibold uppercase tracking-wider text-[#A3A3A3] hover:text-white hover:bg-[#242424] rounded-lg transition-colors">
                                Public Frontend ↗
                            </Link>
                            <div class="h-px bg-[#242424] my-1"></div>
                            <button @click="logout" class="w-full text-left px-3 py-2 text-xs font-display font-semibold uppercase tracking-wider text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                Terminate Session
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Application Viewport -->
            <div class="p-6 sm:p-8 lg:p-10 flex-1 relative bg-[#0D0D0D]">
                <div class="max-w-7xl mx-auto">
                    <slot />
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="p-6 border-t border-[#242424] bg-[#0D0D0D] text-[10px] font-mono text-[#525252] text-center uppercase tracking-widest">
                {{ siteName }} // INDUSTRIAL CONSTRUCTION MANAGEMENT ENGINE
            </footer>
        </main>
        
        <!-- Mobile Sidebar Backdrop -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 lg:hidden"></div>
    </div>
</template>

<style>
.dark-mode {
    --bg-main: #0D0D0D;
    --bg-card: #171717;
    --border: #242424;
    --accent: #E05A1B;
}
</style>
