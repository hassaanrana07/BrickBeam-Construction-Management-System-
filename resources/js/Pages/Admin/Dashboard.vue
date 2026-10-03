<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router, usePage, Link } from '@inertiajs/vue3';
import { ref, computed, inject } from 'vue';
import {
    Chart as ChartJS,
    Title, Tooltip, Legend,
    BarElement, CategoryScale, LinearScale,
    PointElement, LineElement, ArcElement, Filler
} from 'chart.js';
import { Bar, Line, Doughnut } from 'vue-chartjs';

ChartJS.register(
    Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,
    PointElement, LineElement, ArcElement, Filler
);

const page = usePage();
const settings = computed(() => page.props.settings || {});
const currency = computed(() => settings.value?.currency || 'USD');

const props = defineProps({
    user_role:            String,
    stats:                Object,
    chart_data:           Object,
    recent_activity:      Array,
    // Manager
    projects:             Array,
    upcoming_deadlines:   Array,
    // Finance
    recent_expenses:      Array,
    purchase_queue:       Array,
    // Editor / Support
    recent_blogs:         Array,
    recent_inquiries:     Array,
    recent_leads:         Array,
    tasks:                Array,
    attendance:           Array,
    last_attendance:      Object,
    team_members:         Array,
});

const isDark = inject('isDark', ref(true));
const financeTab = ref('overview'); // overview, revenue, profit, team

// ── Chart helpers ─────────────────────────────────────────────────────────────
const textColor    = computed(() => '#A3A3A3');
const tooltipBg    = computed(() => '#171717');
const tooltipText  = computed(() => '#F3F1EC');
const gridColor    = computed(() => 'rgba(255,255,255,0.04)');

const baseOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    animation: { duration: 800, easing: 'easeInOutQuart' },
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: tooltipBg.value,
            titleColor:       tooltipText.value,
            bodyColor:        tooltipText.value,
            borderColor:      '#242424',
            borderWidth: 1,
            padding: 12,
            cornerRadius: 8,
            displayColors: false,
        }
    },
    scales: {
        x: { grid: { display: false }, ticks: { color: textColor.value, font: { size: 9, weight: '700' } } },
        y: { grid: { color: gridColor.value }, ticks: { color: textColor.value, font: { size: 9, weight: '700' } } }
    }
}));

const donutOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true, position: 'bottom',
            labels: { color: textColor.value, font: { size: 9, family: 'monospace' }, padding: 14, boxWidth: 12 }
        },
        tooltip: {
            backgroundColor: tooltipBg.value,
            titleColor: tooltipText.value,
            bodyColor: tooltipText.value,
            borderColor: '#242424',
            borderWidth: 1,
        }
    },
    cutout: '68%'
}));

// ── Utility ───────────────────────────────────────────────────────────────────
const formatCurrency = (val) => {
    const curr = currency.value || 'USD';
    try {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: curr, maximumFractionDigits: 0 }).format(val || 0);
    } catch {
        return `${curr} ${Number(val || 0).toLocaleString()}`;
    }
};

const formatDate = (date) => {
    if (!date) return 'N/A';
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
};

// Role helpers
const role = computed(() => props.user_role || '');
const isSuperAdmin = computed(() => role.value === 'Super Admin');
const isFinance    = computed(() => ['Finance Manager', 'Finance Support', 'Financial Support', 'Finance', 'Manager', 'Admin Manager'].includes(role.value));

const exportDashboardSummary = () => {
    window.print();
};
</script>

<template>
    <AdminLayout>
        <Head title="Operational Command Nexus" />
        <div class="space-y-10">
            <!-- ═══════════════════════════════════════════════
                 SUPER ADMIN DASHBOARD
            ════════════════════════════════════════════════ -->
            <template v-if="isSuperAdmin">
                <div class="space-y-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#171717] border border-[#242424] rounded-lg mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B] animate-pulse"></span>
                                <span class="industrial-badge text-[#E05A1B] text-[9px]">COMMAND MATRIX</span>
                            </div>
                            <h1 class="font-display text-2xl sm:text-3xl font-extrabold uppercase tracking-tight text-white">Super Admin Nexus</h1>
                            <p class="text-xs text-[#A3A3A3] mt-1 font-mono">Real-time system telemetry, project portfolios & Earned Value ledger</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button 
                                @click="exportDashboardSummary"
                                class="px-4 py-2.5 bg-[#171717] hover:bg-[#242424] border border-[#242424] hover:border-[#525252] text-white text-[10px] font-display font-bold uppercase tracking-wider rounded-lg flex items-center gap-2 transition-all shadow-md"
                            >
                                <svg class="w-4 h-4 text-[#E5A93C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                <span>Export Report</span>
                            </button>
                            <span class="px-3.5 py-2 bg-[#171717] border border-[#242424] text-[#E05A1B] text-[9px] font-mono font-bold uppercase tracking-widest rounded-lg flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                {{ stats?.system_health || 'OPTIMAL 99.9%' }}
                            </span>
                        </div>
                    </div>

                    <!-- 4 Top Executive KPI Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div v-for="kpi in [
                            { label: 'Total Projects',    val: stats?.total_projects,    icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z', accent: 'text-[#E5A93C]', bar: 'bg-[#E5A93C]', trend: '+12%' },
                            { label: 'Active Sites',      val: stats?.active_projects,   icon: 'M13 10V3L4 14h7v7l9-11h-7z', accent: 'text-[#E05A1B]', bar: 'bg-[#E05A1B]', trend: 'Optimal' },
                            { label: 'Completed As-Built',val: stats?.completed_projects,icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', accent: 'text-emerald-400', bar: 'bg-emerald-400', trend: '+100%' },
                            { label: 'System Operatives', val: stats?.user_count,        icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', accent: 'text-white', bar: 'bg-white', trend: '+8%' },
                        ]" :key="kpi.label" class="industrial-panel bg-[#171717] border border-[#242424] p-7 rounded-2xl relative overflow-hidden group hover:border-[#E05A1B]/50 transition-all duration-300 shadow-2xl">
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-11 h-11 rounded-xl bg-[#242424] border border-[#383838] flex items-center justify-center text-[#E05A1B]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="kpi.icon" /></svg>
                                </div>
                                <span class="text-[9px] font-mono font-bold text-emerald-400 px-2 py-0.5 bg-[#242424] rounded border border-[#383838]">{{ kpi.trend }}</span>
                            </div>
                            <p class="industrial-badge text-[9px] text-[#737373] mb-1.5">{{ kpi.label }}</p>
                            <p class="font-display text-4xl font-black text-white tracking-tight">{{ kpi.val ?? '—' }}</p>
                            
                            <!-- Accent Bar at bottom -->
                            <div class="absolute bottom-0 left-0 w-full h-1 bg-[#242424]">
                                <div class="h-full w-2/5 transition-all duration-700" :class="kpi.bar"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Matrix & Revenue Inflow -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                            <h2 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">Financial Matrix & Earned Value Inflow</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="kpi in [
                                { label: 'Overall Projected Revenue', val: formatCurrency(stats?.total_expected), accent: 'text-[#E5A93C]', sub: 'Total Contract Value' },
                                { label: 'Incoming Inflow (Received)', val: formatCurrency(stats?.total_revenue), accent: 'text-emerald-400', sub: `${stats?.collection_rate?.toFixed(1) || 92.8}% Collection Rate` },
                                { label: 'Pending Arrears (Receivables)', val: formatCurrency(stats?.total_pending), accent: 'text-[#E05A1B]', sub: 'Outstanding Milestone Billings' },
                                { label: 'Net Enterprise Profit', val: formatCurrency(stats?.total_profit), accent: 'text-emerald-400', sub: `${stats?.profit_margin?.toFixed(1) || 24.5}% Avg. Margin` },
                                { label: 'Overall Fiscal Loss / Contingency', val: formatCurrency(stats?.total_loss || 0), accent: 'text-red-400', sub: 'Deficit / Overheads' },
                                { label: 'Operational Consumption (Expenses)', val: formatCurrency(stats?.total_expenses), accent: 'text-[#A3A3A3]', sub: 'Total Asset & Trade Consumption' },
                            ]" :key="kpi.label" class="industrial-panel bg-[#171717] border border-[#242424] p-7 rounded-2xl hover:border-[#E05A1B]/50 transition-all duration-300 shadow-2xl relative">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="industrial-badge text-[8px] text-[#737373]">FINANCIAL TELEMETRY</span>
                                    <span class="w-2 h-2 rounded-full bg-[#E05A1B]"></span>
                                </div>
                                <p class="industrial-badge text-[9px] text-[#A3A3A3] mb-1.5">{{ kpi.label }}</p>
                                <p class="font-display text-3xl font-extrabold tracking-tight" :class="kpi.accent">{{ kpi.val ?? '—' }}</p>
                                <p class="text-[9px] text-[#737373] mt-3 font-mono flex items-center gap-2 border-t border-[#242424] pt-3">
                                    {{ kpi.sub }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Inflow Chart -->
                    <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    <h3 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">Inflow Protocol Stream (Expected vs Received)</h3>
                                </div>
                                <p class="text-[10px] font-mono text-[#737373] mt-0.5">Monthly reconciliation of capital influx against contractual baseline</p>
                            </div>
                            <div class="flex items-center gap-4 text-[9px] font-mono">
                                <span class="flex items-center gap-1.5 text-emerald-400"><span class="w-2 h-2 rounded-full bg-emerald-400"></span>Received</span>
                                <span class="flex items-center gap-1.5 text-[#A3A3A3]"><span class="w-2 h-2 rounded-full bg-[#383838]"></span>Expected</span>
                            </div>
                        </div>
                        <div class="h-80">
                            <Bar v-if="chart_data?.revenue_stream" :data="{
                                labels: chart_data.revenue_stream.labels,
                                datasets: [
                                    { label: 'Received Inflow', data: chart_data.revenue_stream.received, backgroundColor: '#10b981', borderRadius: 4 },
                                    { label: 'Expected Revenue', data: chart_data.revenue_stream.expected, backgroundColor: '#27272a', borderRadius: 4 }
                                ]
                            }" :options="baseOptions" />
                        </div>
                    </div>

                    <!-- Profit vs Loss and Collection Matrix -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <h3 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">Strategic Profit vs Loss Trajectory</h3>
                            </div>
                            <div class="h-[340px]">
                                <Line v-if="chart_data?.profit_loss_trend" :data="{
                                    labels: chart_data.profit_loss_trend.labels,
                                    datasets: [
                                        { 
                                            label: 'Net Profit', 
                                            data: chart_data.profit_loss_trend.profit, 
                                            borderColor: '#10b981', 
                                            backgroundColor: 'rgba(16, 185, 129, 0.1)', 
                                            fill: true,
                                            tension: 0.4
                                        },
                                        { 
                                            label: 'Fiscal Loss', 
                                            data: chart_data.profit_loss_trend.loss, 
                                            borderColor: '#ef4444', 
                                            backgroundColor: 'rgba(239, 68, 68, 0.1)', 
                                            fill: true,
                                            tension: 0.4
                                        }
                                    ]
                                }" :options="baseOptions" />
                            </div>
                        </div>
                        <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <h3 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">Fiscal Collection Matrix (Rec. vs Pending)</h3>
                            </div>
                            <div class="h-[340px]">
                                <Bar v-if="chart_data?.collection_matrix" :data="{
                                    labels: chart_data.collection_matrix.labels,
                                    datasets: [
                                        { label: 'Inflow (Received)', data: chart_data.collection_matrix.received, backgroundColor: '#10b981', borderRadius: 4 },
                                        { label: 'Delta (Pending)', data: chart_data.collection_matrix.pending, backgroundColor: '#ef4444', borderRadius: 4 }
                                    ]
                                }" :options="baseOptions" />
                            </div>
                        </div>
                    </div>

                    <!-- Asset Consumption & Product Strategy Matrix -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl lg:col-span-2 shadow-2xl">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <h3 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">Operational Asset Consumption</h3>
                            </div>
                            <div class="h-64">
                                <Bar v-if="chart_data?.financial_overview" :data="{
                                    labels: chart_data.financial_overview.labels,
                                    datasets: [
                                        { label: 'Revenue', data: chart_data.financial_overview.revenue, backgroundColor: '#E05A1B', borderRadius: 4 },
                                        { label: 'Expenses', data: chart_data.financial_overview.expenses, backgroundColor: '#ef4444', borderRadius: 4 }
                                    ]
                                }" :options="baseOptions" />
                            </div>
                        </div>
                        <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <h3 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">Product Strategy Matrix</h3>
                            </div>
                            <div class="h-64 flex items-center justify-center">
                                <Doughnut v-if="chart_data?.product_stats" :data="{
                                    labels: chart_data.product_stats.labels,
                                    datasets: [{
                                        data: chart_data.product_stats.values,
                                        backgroundColor: ['#E05A1B', '#10b981', '#E5A93C', '#ef4444'],
                                        borderWidth: 0,
                                        hoverOffset: 12
                                    }]
                                }" :options="donutOptions" />
                            </div>
                        </div>
                    </div>

                    <!-- Audit Stream & Revenue by Status -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    <h3 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">System Audit Stream</h3>
                                </div>
                                <Link :href="route('admin.audit-logs.index')" class="text-[9px] font-mono text-[#E05A1B] uppercase hover:underline">Full Log →</Link>
                            </div>
                            <div class="space-y-3 max-h-[380px] overflow-y-auto custom-scrollbar pr-2">
                                <div v-for="log in recent_activity" :key="log.id" class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl hover:border-[#E05A1B]/40 transition-all">
                                    <div class="flex justify-between items-start">
                                        <p class="text-xs font-display font-bold uppercase text-white tracking-wider">{{ log.action }}</p>
                                        <p class="text-[8px] text-[#737373] font-mono uppercase">{{ formatDate(log.created_at) }}</p>
                                    </div>
                                    <p class="text-[9px] text-[#A3A3A3] mt-1 font-mono">{{ log.user?.name || 'System' }} · Remote Admin Clearance</p>
                                </div>
                            </div>
                        </div>
                        <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <h3 class="font-display text-xs font-black uppercase tracking-[0.25em] text-blue-500">Revenue Distribution by Status</h3>
                            </div>
                            <div class="h-64 flex items-center justify-center">
                                <Doughnut v-if="chart_data?.revenue_by_status" :data="{
                                    labels: chart_data.revenue_by_status.labels,
                                    datasets: [{
                                        data: chart_data.revenue_by_status.values,
                                        backgroundColor: ['#E05A1B', '#10b981', '#E5A93C', '#ef4444'],
                                        borderWidth: 0,
                                    }]
                                }" :options="donutOptions" />
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- ═══════════════════════════════════════════════
                 FINANCE & MANAGEMENT DASHBOARD
            ════════════════════════════════════════════════ -->
            <template v-else-if="isFinance">
                <div class="space-y-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight text-white">Financial Hub</h1>
                            <p class="text-xs text-[#A3A3A3] font-mono mt-1">{{ user_role }} — Strategic fiscal command & capital tracking</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 border-b border-[#242424] pb-1">
                        <button v-for="tab in [
                            { id: 'overview', label: 'Overview Control' },
                            { id: 'revenue',  label: 'Revenue Matrix' },
                            { id: 'profit',   label: 'Profit Ledger' },
                            { id: 'team',     label: 'Finance Team' }
                        ]" :key="tab.id" @click="financeTab = tab.id" :class="financeTab === tab.id ? 'text-[#E05A1B] border-b-2 border-[#E05A1B] pb-3' : 'text-[#737373] hover:text-white pb-3'" class="text-xs font-display font-bold uppercase tracking-wider transition-colors">
                            {{ tab.label }}
                        </button>
                    </div>

                    <!-- Overview Control -->
                    <div v-if="financeTab === 'overview'" class="space-y-10 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="kpi in [
                                { label: 'Overall Projected Revenue', val: formatCurrency(stats?.total_expected), accent: 'text-[#E5A93C]', sub: 'Total Contract Value' },
                                { label: 'Incoming Inflow (Received)', val: formatCurrency(stats?.total_revenue), accent: 'text-emerald-400', sub: `${stats?.collection_rate?.toFixed(1) || 92.8}% Collection Rate` },
                                { label: 'Pending Arrears (Receivables)', val: formatCurrency(stats?.total_pending), accent: 'text-[#E05A1B]', sub: 'Outstanding Invoices' },
                                { label: 'Net Enterprise Profit', val: formatCurrency(stats?.total_profit), accent: 'text-emerald-400', sub: `${stats?.profit_margin?.toFixed(1) || 24.5}% Avg. Margin` },
                                { label: 'Overall Fiscal Loss', val: formatCurrency(stats?.total_loss || 0), accent: 'text-red-400', sub: 'Deficit / Overheads' },
                                { label: 'Total Active Projects', val: Math.round(stats?.project_count || 6), accent: 'text-white', sub: `${stats?.ongoing_count || 4} Ongoing · ${stats?.pending_count || 2} Pending` },
                            ]" :key="kpi.label" class="industrial-panel bg-[#171717] border border-[#242424] p-7 rounded-2xl hover:border-[#E05A1B]/50 transition-all duration-300 shadow-2xl">
                                <p class="industrial-badge text-[9px] text-[#737373] mb-1.5">{{ kpi.label }}</p>
                                <p class="font-display text-3xl font-extrabold tracking-tight" :class="kpi.accent">{{ kpi.val ?? '—' }}</p>
                                <p class="text-[9px] text-[#737373] mt-3 font-mono border-t border-[#242424] pt-3">{{ kpi.sub }}</p>
                            </div>
                        </div>

                        <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                            <h3 class="font-display text-sm font-bold uppercase tracking-wider text-white mb-6">Inflow Protocol Stream (Expected vs Received)</h3>
                            <div class="h-80">
                                <Bar v-if="chart_data?.revenue_stream" :data="{
                                    labels: chart_data.revenue_stream.labels,
                                    datasets: [
                                        { label: 'Received Inflow', data: chart_data.revenue_stream.received, backgroundColor: '#10b981', borderRadius: 4 },
                                        { label: 'Expected Revenue', data: chart_data.revenue_stream.expected, backgroundColor: '#27272a', borderRadius: 4 }
                                    ]
                                }" :options="baseOptions" />
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Matrix Tab -->
                    <div v-if="financeTab === 'revenue'" class="space-y-10 animate-fade-in">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2 industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                                <h3 class="font-display text-sm font-bold uppercase tracking-wider text-white mb-6">Revenue Inflow Stream</h3>
                                <div class="h-80">
                                    <Line v-if="chart_data?.financial_overview" :data="{
                                        labels: chart_data.financial_overview.labels,
                                        datasets: [{
                                            label: 'Inflow',
                                            data: chart_data.financial_overview.revenue,
                                            borderColor: '#10b981',
                                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                            fill: true,
                                            tension: 0.4
                                        }]
                                    }" :options="baseOptions" />
                                </div>
                            </div>
                            <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                                <h3 class="font-display text-sm font-bold uppercase tracking-wider text-white mb-6">Top Revenue Sources</h3>
                                <div class="space-y-5">
                                    <div v-for="p in projects?.slice(0, 5)" :key="p.id" class="space-y-1.5">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="font-display font-bold uppercase text-white truncate w-36">{{ p.title }}</span>
                                            <span class="font-mono text-emerald-400 font-bold">{{ formatCurrency(p.received_payment) }}</span>
                                        </div>
                                        <div class="w-full bg-[#0D0D0D] h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full" :style="{ width: ((p.received_payment / (stats?.total_revenue || 1)) * 100) + '%' }"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profit Ledger Tab -->
                    <div v-if="financeTab === 'profit'" class="space-y-10 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl flex flex-col justify-between shadow-2xl">
                                <div>
                                    <h3 class="font-display text-sm font-bold uppercase tracking-wider text-white mb-6 border-b border-[#242424] pb-4">Efficiency Metrics</h3>
                                    <div class="space-y-6">
                                        <div>
                                            <p class="industrial-badge text-[9px] text-[#737373] mb-1">Avg. Project Profit</p>
                                            <p class="font-display text-3xl font-extrabold text-white">{{ formatCurrency(stats?.average_profit) }}</p>
                                        </div>
                                        <div>
                                            <p class="industrial-badge text-[9px] text-[#737373] mb-1">Gross Profit Margin</p>
                                            <p class="font-display text-3xl font-extrabold text-[#E05A1B]">{{ stats?.profit_margin?.toFixed(1) || '24.5' }}%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-span-2 industrial-panel bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                                <h3 class="font-display text-sm font-bold uppercase tracking-wider text-white mb-6">Profit vs Loss Trajectory</h3>
                                <div class="h-[350px]">
                                    <Line v-if="chart_data?.profit_loss_trend" :data="{
                                        labels: chart_data.profit_loss_trend.labels,
                                        datasets: [
                                            { 
                                                label: 'Net Profit', 
                                                data: chart_data.profit_loss_trend.profit, 
                                                borderColor: '#10b981', 
                                                backgroundColor: 'rgba(16, 185, 129, 0.1)', 
                                                fill: true,
                                                tension: 0.4
                                            },
                                            { 
                                                label: 'Fiscal Loss', 
                                                data: chart_data.profit_loss_trend.loss, 
                                                borderColor: '#ef4444', 
                                                backgroundColor: 'rgba(239, 68, 68, 0.1)', 
                                                fill: true,
                                                tension: 0.4
                                            }
                                        ]
                                    }" :options="baseOptions" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Finance Team Tab -->
                    <div v-if="financeTab === 'team'" class="space-y-10 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div v-for="member in team_members" :key="member.id" class="industrial-panel bg-[#171717] border border-[#242424] p-6 rounded-2xl flex items-center gap-4 hover:border-[#E05A1B]/50 transition-all shadow-xl">
                                <div class="w-12 h-12 bg-[#242424] border border-[#383838] flex items-center justify-center font-display font-bold text-lg text-white rounded-xl">{{ member.name.charAt(0) }}</div>
                                <div>
                                    <h3 class="font-display text-sm font-bold text-white uppercase">{{ member.name }}</h3>
                                    <p class="text-[10px] font-mono text-[#E05A1B] mt-0.5">{{ member.email }}</p>
                                    <span class="mt-2 inline-block px-2 py-0.5 bg-[#242424] border border-[#383838] text-[8px] font-mono uppercase text-[#A3A3A3] rounded">{{ member.roles?.[0]?.name || 'Finance Operative' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- ═══════════════════════════════════════════════
                 FALLBACK DASHBOARD
            ════════════════════════════════════════════════ -->
            <template v-else>
                <div class="flex flex-col items-center justify-center py-40 gap-6 text-center">
                    <div class="w-16 h-16 bg-[#171717] border border-[#242424] rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-[#E05A1B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5z" /></svg>
                    </div>
                    <div class="space-y-2">
                        <p class="font-display text-sm font-bold uppercase tracking-widest text-white">Operational Access Restricted</p>
                        <p class="text-xs font-mono text-[#737373]">Role: {{ user_role || 'General Staff' }}</p>
                    </div>
                    <p class="text-xs text-[#A3A3A3] max-w-sm leading-relaxed">Please authenticate with security clearance or contact the systems administrator for dashboard deployment.</p>
                </div>
            </template>
        </div>
    </AdminLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 2px; }
.custom-scrollbar::-webkit-scrollbar-track { background-color: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background-color: #242424; border-radius: 999px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #E05A1B; }
</style>
