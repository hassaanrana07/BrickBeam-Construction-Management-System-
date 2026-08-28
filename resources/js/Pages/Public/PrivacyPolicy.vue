<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <PublicLayout>
        <Head title="Privacy Policy — BrickBeam Construction Platform" />

        <!-- 1. HERO SECTION -->
        <section class="relative pt-36 pb-20 lg:pt-48 lg:pb-24 bg-[#050811] text-white border-b border-white/[0.08] overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img 
                    src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070" 
                    alt="BrickBeam Security and Compliance" 
                    class="w-full h-full object-cover filter brightness-[0.2] contrast-125 scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#050811] via-[#050811]/80 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#050811]/95 via-[#581c87]/20 to-transparent"></div>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-purple-950/60 border border-purple-500/30 rounded-full backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                        <span class="text-[10px] font-black tracking-[0.25em] text-purple-300 uppercase">
                            LEGAL & COMPLIANCE
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight uppercase leading-tight text-white">
                        PRIVACY <span class="text-orange-500">POLICY.</span>
                    </h1>

                    <p class="text-slate-400 text-sm sm:text-base">
                        Effective Date: January 1, 2026 • Version 2.4 (Enterprise Construction Security Protocol)
                    </p>
                </div>
            </div>
        </section>

        <!-- 2. POLICY CONTENT -->
        <section class="py-20 lg:py-28 bg-[#070a12] text-slate-300">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 leading-relaxed text-sm sm:text-base">
                
                <div class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-4">
                    <h2 class="text-xl font-black uppercase text-white tracking-tight flex items-center gap-3">
                        <span class="w-2 h-6 bg-purple-600 rounded-full"></span>
                        1. Architectural Data Governance Overview
                    </h2>
                    <p>
                        BrickBeam ("we," "our," or "the Platform") provides an institutional-grade construction management software ecosystem. We are committed to safeguarding project documentation, architectural models, financial baselines, and team telemetry ingested into our systems.
                    </p>
                </div>

                <div class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-4">
                    <h2 class="text-xl font-black uppercase text-white tracking-tight flex items-center gap-3">
                        <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
                        2. Information We Ingest & Process
                    </h2>
                    <ul class="space-y-2 list-disc pl-5 text-slate-400 text-sm">
                        <li><strong class="text-white">Account Information:</strong> Name, professional title, corporate email, phone, and company authorization credentials.</li>
                        <li><strong class="text-white">Jobsite Telemetry:</strong> Geo-tagged inspection photos, daily task logs, drone survey uploads, and milestone timestamps.</li>
                        <li><strong class="text-white">Financial & BOQ Data:</strong> Purchase orders, cost codes, earned value indices, and contractor payment draw records.</li>
                        <li><strong class="text-white">Device & Access Logs:</strong> IP addresses, browser fingerprinting, audit trail stamps, and biometric verification tokens where enabled.</li>
                    </ul>
                </div>

                <div class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-4">
                    <h2 class="text-xl font-black uppercase text-white tracking-tight flex items-center gap-3">
                        <span class="w-2 h-6 bg-purple-600 rounded-full"></span>
                        3. How Information is Utilized
                    </h2>
                    <p>
                        Data processed on BrickBeam is strictly utilized to deliver critical path project management, automated variance calculation, multi-trade task routing, and tamper-evident audit dossier generation. We do not sell or monetize proprietary construction drawings or financial estimates to third parties.
                    </p>
                </div>

                <div class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-4">
                    <h2 class="text-xl font-black uppercase text-white tracking-tight flex items-center gap-3">
                        <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
                        4. Security & Encryption Standards
                    </h2>
                    <p>
                        All jobsite transmissions and cloud repositories are protected by AES-256 encryption at rest and TLS 1.3 in transit. Multi-factor authentication (MFA) and strict role-based access control (RBAC) ensure that subcontractors only view allocated tasks while general contractors and project owners retain full portfolio visibility.
                    </p>
                </div>

                <div class="p-8 bg-[#0a0f1d] border border-white/[0.08] rounded-3xl space-y-4">
                    <h2 class="text-xl font-black uppercase text-white tracking-tight flex items-center gap-3">
                        <span class="w-2 h-6 bg-purple-600 rounded-full"></span>
                        5. Contact Legal & Security Desk
                    </h2>
                    <p>
                        For inquiries regarding privacy, data audits, or SOC-2 compliance dossiers, please reach our governance team at:
                    </p>
                    <p class="text-orange-400 font-bold">
                        Email: privacy@brickbeam.com • Operational PMO Desk: +92 (51) 884-2900
                    </p>
                </div>

                <div class="pt-6 text-center">
                    <Link 
                        :href="route('contact')"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-purple-900/60 hover:bg-orange-500 border border-purple-500/30 hover:border-orange-500 text-white font-black uppercase tracking-widest text-xs rounded-xl transition-all duration-300 shadow-xl"
                    >
                        <span>Contact Compliance Officer</span>
                        <span>→</span>
                    </Link>
                </div>

            </div>
        </section>

    </PublicLayout>
</template>
