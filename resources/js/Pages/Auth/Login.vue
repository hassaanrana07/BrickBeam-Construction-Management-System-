<script setup>
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings || {});
const siteName = computed(() => settings.value?.site_name || 'Brick & Beam');
const companyLogo = computed(() => settings.value?.company_logo || null);

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const brandingMode = computed(() => settings.value?.login_branding_mode || 'both');

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="System Access | BrickBeam" />

    <div class="min-h-screen flex flex-col md:flex-row font-sans bg-[#0D0D0D] text-[#F3F1EC] overflow-hidden selection:bg-[#E05A1B] selection:text-[#0D0D0D]">
        
        <!-- Left Side: Login Inputs (Deep Charcoal) -->
        <div class="w-full md:w-1/2 bg-[#0D0D0D] border-r border-[#242424] flex flex-col justify-center px-8 sm:px-12 lg:px-20 py-16 relative z-20">
            <div class="max-w-md mx-auto w-full space-y-10">
                
                <!-- Logo & Brand Header -->
                <div class="space-y-4">
                    <Link :href="route('home')" class="inline-flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-[#171717] border border-[#242424] group-hover:border-[#E05A1B] rounded-xl flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 text-[#E05A1B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <line x1="3" y1="9" x2="21" y2="9" />
                                <line x1="9" y1="21" x2="9" y2="9" />
                                <line x1="15" y1="21" x2="15" y2="9" />
                            </svg>
                        </div>
                        <span class="font-display text-2xl font-bold text-white tracking-tight">
                            BRICK<span class="text-[#E05A1B]">BEAM</span>
                        </span>
                    </Link>

                    <div>
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-[#171717] border border-[#242424] rounded text-[9px] font-mono text-[#E05A1B] mb-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B] animate-pulse"></span>
                            AUTHENTICATION GATEWAY
                        </div>
                        <h2 class="font-display text-3xl font-extrabold text-white uppercase tracking-tight">
                            System Access
                        </h2>
                        <p class="text-[#A3A3A3] text-xs font-medium mt-1">
                            Authenticate security credentials to access the project control center.
                        </p>
                    </div>
                </div>

                <div v-if="status" class="p-4 bg-[#171717] border-l-4 border-[#E05A1B] text-[#E5A93C] text-xs font-mono font-bold uppercase tracking-wider">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-4">
                        <div class="group">
                            <label class="industrial-badge text-[#A3A3A3] group-focus-within:text-[#E05A1B] transition-colors block mb-2">
                                Access Identifier (Email)
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                autofocus
                                class="w-full bg-[#171717] border border-[#242424] focus:border-[#E05A1B] focus:ring-1 focus:ring-[#E05A1B] rounded-xl px-4 py-3.5 text-white font-medium placeholder-[#525252] transition-all outline-none text-sm"
                                placeholder="admin@brickbeam.com"
                            />
                            <div v-if="form.errors.email" class="text-xs font-mono text-red-500 mt-1.5 font-semibold">{{ form.errors.email }}</div>
                        </div>

                        <div class="group">
                            <label class="industrial-badge text-[#A3A3A3] group-focus-within:text-[#E05A1B] transition-colors block mb-2">
                                Security Passkey
                            </label>
                            <input
                                v-model="form.password"
                                type="password"
                                required
                                class="w-full bg-[#171717] border border-[#242424] focus:border-[#E05A1B] focus:ring-1 focus:ring-[#E05A1B] rounded-xl px-4 py-3.5 text-white font-medium placeholder-[#525252] transition-all outline-none text-sm"
                                placeholder="••••••••"
                            />
                            <div v-if="form.errors.password" class="text-xs font-mono text-red-500 mt-1.5 font-semibold">{{ form.errors.password }}</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" v-model="form.remember" class="w-4 h-4 bg-[#171717] border-[#242424] text-[#E05A1B] focus:ring-0 rounded cursor-pointer" />
                            <span class="ms-2.5 text-[#A3A3A3] hover:text-white transition-colors">Maintain Session</span>
                        </label>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] py-4 px-6 font-display font-bold uppercase tracking-wider text-xs rounded-xl transition-all active:scale-[0.98] disabled:opacity-50 shadow-lg shadow-[#E05A1B]/20"
                    >
                        {{ form.processing ? 'Verifying Security Tokens...' : 'Establish Connection' }}
                    </button>
                    
                    <div class="flex flex-col items-center gap-3 pt-2 text-xs">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-[#525252] hover:text-[#E05A1B] transition-colors font-mono"
                        >
                            Reset Access Protocols
                        </Link>
                        <div class="flex items-center gap-1.5 text-[#525252]">
                            <span>Need administrative credentials?</span>
                            <Link
                                :href="route('contact')"
                                class="text-[#E05A1B] hover:underline"
                            >
                                Contact Systems Admin
                            </Link>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- Right Side: Architectural Telemetry & Systems Summary -->
        <div class="w-full md:w-1/2 bg-[#171717] relative overflow-hidden flex flex-col justify-center px-8 sm:px-12 lg:px-20 py-16">
            <!-- CAD Blueprint Background -->
            <div class="absolute inset-0 cad-grid opacity-30 pointer-events-none"></div>

            <div class="relative z-10 space-y-8 max-w-lg">
                <div class="space-y-4">
                    <span class="industrial-badge text-[#E05A1B] text-[10px]">
                        ENTERPRISE CONSTRUCTION OPERATING SYSTEM
                    </span>
                    <h1 class="font-display text-4xl sm:text-5xl font-extrabold uppercase tracking-tight text-white leading-tight">
                        Precision Control Over Every Jobsite<span class="text-[#E05A1B]">.</span>
                    </h1>
                    <p class="text-[#A3A3A3] text-sm leading-relaxed">
                        Integrated Earned Value Management, real-time schedule mitigation, and verified multi-trade execution.
                    </p>
                </div>

                <div class="space-y-4 pt-4 border-t border-[#242424]">
                    <div class="p-4 bg-[#111111] border border-[#242424] rounded-xl flex items-center gap-4">
                        <div class="w-9 h-9 rounded-lg bg-[#242424] flex items-center justify-center text-[#E05A1B]">
                            ✓
                        </div>
                        <div>
                            <h4 class="font-display text-xs font-bold text-white uppercase">Multi-Project EVM Tracking</h4>
                            <p class="text-[11px] text-[#A3A3A3]">Automated CPI and SPI variance monitoring</p>
                        </div>
                    </div>

                    <div class="p-4 bg-[#111111] border border-[#242424] rounded-xl flex items-center gap-4">
                        <div class="w-9 h-9 rounded-lg bg-[#242424] flex items-center justify-center text-[#E05A1B]">
                            ✓
                        </div>
                        <div>
                            <h4 class="font-display text-xs font-bold text-white uppercase">Field Photo Verification</h4>
                            <p class="text-[11px] text-[#A3A3A3]">Geo-located defect checklists & daily tickets</p>
                        </div>
                    </div>

                    <div class="p-4 bg-[#111111] border border-[#242424] rounded-xl flex items-center gap-4">
                        <div class="w-9 h-9 rounded-lg bg-[#242424] flex items-center justify-center text-[#E05A1B]">
                            ✓
                        </div>
                        <div>
                            <h4 class="font-display text-xs font-bold text-white uppercase">Role-Based Access Matrix</h4>
                            <p class="text-[11px] text-[#A3A3A3]">Fine-grained permissions for Super Admins, Managers & Trades</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between text-[10px] font-mono text-[#525252] border-t border-[#242424]">
                    <span>STATUS: OPERATIONAL</span>
                    <span>© {{ new Date().getFullYear() }} BRICKBEAM SYSTEM</span>
                </div>
            </div>
        </div>

    </div>
</template>
