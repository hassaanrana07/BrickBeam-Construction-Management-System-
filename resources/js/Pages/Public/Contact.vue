<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    page: Object,
    locations: Array
});

const form = useForm({
    name: '',
    email: '',
    subject: '',
    phone: '',
    company: '',
    project_type: 'Commercial High-Rise',
    message: ''
});

const submit = () => {
    form.post(route('contact.submit'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

// EXACT 3 MANDATORY LOCATIONS ONLY: Lahore, Islamabad, Rajiv
const officialLocations = [
    {
        id: 'lahore',
        name: 'Lahore',
        country: 'Pakistan',
        address: 'MM Alam Road, Gulberg III',
        phone: '+92 (42) 3578-9000',
        email: 'lahore@brickbeam.com'
    },
    {
        id: 'islamabad',
        name: 'Islamabad',
        country: 'Pakistan',
        address: 'Blue Area Commercial Hub',
        phone: '+92 (51) 884-2900',
        email: 'islamabad@brickbeam.com'
    },
    {
        id: 'rajiv',
        name: 'Rajiv',
        country: 'Regional Hub',
        address: 'BrickBeam Regional Bureau',
        phone: '+92 (51) 884-2901',
        email: 'rajiv@brickbeam.com'
    }
];
</script>

<template>
    <PublicLayout>
        <Head title="Contact & Project Inception — BrickBeam" />

        <!-- 1. HERO SECTION -->
        <div class="relative pt-36 pb-20 lg:pt-48 lg:pb-28 bg-[#050811] text-white border-b border-white/[0.08] overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069" 
                    @error="($event) => $event.target.src = 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=2070'"
                    alt="BrickBeam Engineering Office"
                    class="w-full h-full object-cover object-center filter brightness-[0.22] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#050811] via-[#050811]/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#050811]/95 via-[#581c87]/30 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-purple-950/60 border border-purple-500/30 rounded-full backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                        <span class="text-[11px] font-black tracking-[0.25em] text-purple-300 uppercase">
                            CONSULTATION & INQUIRY
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight uppercase leading-[1.08] text-white">
                        INITIATE YOUR <span class="text-orange-500">PROJECT.</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-normal">
                        Connect directly with our construction managers, structural estimators, and technology directors to plan your next development.
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. CONTACT FORM & LOCATIONS SECTION -->
        <section class="py-24 lg:py-32 bg-[#050811] text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                <!-- Left: Inquiry Form -->
                <div class="lg:col-span-7 bg-[#0a0f1d] border border-white/[0.08] p-8 sm:p-12 rounded-3xl space-y-8 shadow-2xl">
                    <div class="space-y-2">
                        <span class="text-[10px] font-black uppercase tracking-[0.25em] text-purple-300">Direct Dispatch</span>
                        <h2 class="text-2xl sm:text-4xl font-black uppercase tracking-tight text-white">
                            Send an Inquiry<span class="text-orange-500">.</span>
                        </h2>
                        <p class="text-slate-400 text-sm">Fill out the parameters below and our engineering desk will respond within 24 hours.</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Full Name *</label>
                                <input 
                                    v-model="form.name" 
                                    type="text" 
                                    required 
                                    class="w-full bg-[#050811] border border-white/10 px-5 py-4 text-sm text-white rounded-xl focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
                                    placeholder="e.g. Engr. Arthur Beam"
                                >
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Address *</label>
                                <input 
                                    v-model="form.email" 
                                    type="email" 
                                    required 
                                    class="w-full bg-[#050811] border border-white/10 px-5 py-4 text-sm text-white rounded-xl focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
                                    placeholder="name@company.com"
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Phone Number</label>
                                <input 
                                    v-model="form.phone" 
                                    type="text" 
                                    class="w-full bg-[#050811] border border-white/10 px-5 py-4 text-sm text-white rounded-xl focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
                                    placeholder="+92 300 0000000"
                                >
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Company / Organization</label>
                                <input 
                                    v-model="form.company" 
                                    type="text" 
                                    class="w-full bg-[#050811] border border-white/10 px-5 py-4 text-sm text-white rounded-xl focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
                                    placeholder="Global Builders Ltd."
                                >
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Project Category</label>
                            <select 
                                v-model="form.project_type"
                                class="w-full bg-[#050811] border border-white/10 px-5 py-4 text-sm text-white rounded-xl focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
                            >
                                <option>Commercial High-Rise</option>
                                <option>Luxury Residential Development</option>
                                <option>Industrial Logistics Facility</option>
                                <option>Civil Infrastructure & Highway</option>
                                <option>Institutional & Healthcare Facility</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Project Requirements & Timeline *</label>
                            <textarea 
                                v-model="form.message" 
                                rows="5" 
                                required
                                class="w-full bg-[#050811] border border-white/10 px-5 py-4 text-sm text-white rounded-xl focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors leading-relaxed"
                                placeholder="Describe project scope, square footage, location, target start date, and management requirements..."
                            ></textarea>
                        </div>

                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="w-full py-5 bg-orange-500 hover:bg-white text-black font-black uppercase tracking-widest text-xs rounded-xl shadow-xl shadow-orange-500/25 transition-all duration-300 disabled:opacity-50"
                        >
                            {{ form.processing ? 'Transmitting Protocol...' : 'Transmit Project Inquiry' }}
                        </button>

                        <div v-if="$page.props.flash?.success" class="p-4 bg-green-500/10 border border-green-500/30 text-green-400 text-xs font-bold uppercase tracking-wider rounded-xl text-center">
                            {{ $page.props.flash.success }}
                        </div>
                    </form>
                </div>

                <!-- Right: Verified 3 Locations (Lahore, Islamabad, Rajiv) & Hotline -->
                <div class="lg:col-span-5 space-y-8">
                    
                    <div class="space-y-2">
                        <span class="text-[10px] font-black uppercase tracking-[0.25em] text-purple-300">Physical Presence</span>
                        <h2 class="text-2xl sm:text-4xl font-black uppercase tracking-tight text-white">
                            HQ Nodes<span class="text-orange-500">.</span>
                        </h2>
                    </div>

                    <div class="space-y-6">
                        <div 
                            v-for="loc in officialLocations" 
                            :key="loc.id"
                            class="p-8 bg-[#0a0f1d] border border-white/[0.08] hover:border-purple-500/40 rounded-3xl space-y-3 transition-colors group"
                        >
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-black uppercase tracking-tight text-white group-hover:text-orange-400 transition-colors">
                                    {{ loc.name }}
                                </h3>
                                <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 bg-purple-950/60 border border-purple-800/40 text-purple-300 rounded-md">
                                    {{ loc.country }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider leading-relaxed">
                                {{ loc.address }}
                            </p>
                            <div class="pt-2 border-t border-white/5 space-y-1 text-xs font-bold uppercase tracking-wider">
                                <p class="text-orange-400">{{ loc.phone }}</p>
                                <p class="text-slate-300">{{ loc.email }}</p>
                            </div>
                        </div>

                        <!-- 24/7 Site Emergency Hotline -->
                        <div class="p-8 bg-gradient-to-br from-[#1a0826] to-[#0a0f1d] border border-purple-500/30 rounded-3xl space-y-4 shadow-xl">
                            <span class="text-[10px] font-black uppercase tracking-widest text-orange-400 block">24/7 Site Support</span>
                            <h3 class="text-xl font-black uppercase tracking-tight text-white">
                                Critical Jobsite Support
                            </h3>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Urgent safety compliance, crane logistics, or critical path inquiries for active verified jobsites.
                            </p>
                            <p class="text-2xl font-black text-white tracking-wider pt-2">
                                +92 (51) 884-2900
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </PublicLayout>
</template>
