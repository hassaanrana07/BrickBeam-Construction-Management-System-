<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    Chart as ChartJS,
    Title, Tooltip, Legend,
    BarElement, CategoryScale, LinearScale,
    PointElement, LineElement, ArcElement, Filler
} from 'chart.js';
import { Bar, Doughnut } from 'vue-chartjs';

ChartJS.register(
    Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,
    PointElement, LineElement, ArcElement, Filler
);

const props = defineProps({
    portfolios: Array,
    stats: Object,
    chart_data: Object
});

const baseOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { grid: { display: false }, ticks: { color: '#71717a', font: { size: 9, weight: '700' } } },
        y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#71717a', font: { size: 9, weight: '700' } } }
    }
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0
    }).format(value || 0);
};

const exportCSV = () => {
    if (!props.portfolios || props.portfolios.length === 0) return;

    const headers = ['Project Title', 'Project ID', 'Status', 'Expected Revenue ($)', 'Received Inflow ($)', 'Pending Arrears ($)', 'Date'];
    const rows = props.portfolios.map(p => [
        `"${p.title.replace(/"/g, '""')}"`,
        `"#${p.id}"`,
        `"${p.execution_status || 'N/A'}"`,
        p.expected_revenue || 0,
        p.received_payment || 0,
        p.pending_payment || 0,
        `"${new Date(p.created_at).toISOString().split('T')[0]}"`
    ]);

    const csvContent = 'data:text/csv;charset=utf-8,' + [headers.join(','), ...rows.map(e => e.join(','))].join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', `brickbeam_revenue_ledger_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

const exportPDF = () => {
    window.print();
};
</script>

<template>
    <AdminLayout>
        <Head title="Revenue Matrix | Financial Core" />

        <ModuleHeader title="Revenue Inflow Tracking">
            <template #subtitle>
                <div class="flex flex-col gap-2">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-[#737373]">Monitoring capital influx and outstanding receivables across all projects.</p>
                </div>
            </template>
            <template #actions>
                <div class="flex items-center gap-3">
                    <button 
                        @click="exportCSV"
                        class="px-4 py-2.5 bg-[#171717] hover:bg-[#242424] border border-[#242424] hover:border-[#525252] text-white text-[10px] font-display font-bold uppercase tracking-wider rounded-lg flex items-center gap-2 transition-all shadow-md"
                    >
                        <svg class="w-4 h-4 text-[#E5A93C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Export CSV</span>
                    </button>
                    <button 
                        @click="exportPDF"
                        class="px-4 py-2.5 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] text-[10px] font-display font-bold uppercase tracking-wider rounded-lg flex items-center gap-2 transition-all shadow-md"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        <span>Export PDF / Print</span>
                    </button>
                </div>
            </template>
        </ModuleHeader>

        <!-- Dynamic Visualization Matrix -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <div class="lg:col-span-2 bg-[#171717] border border-[#242424] p-8 rounded-2xl relative overflow-hidden group shadow-2xl">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-[10px] font-display font-bold uppercase tracking-[0.3em] text-white">Inflow Protocol Stream</h3>
                    <div class="flex gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            <span class="text-[8px] font-mono uppercase text-[#A3A3A3] tracking-widest">Received</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-[#383838] rounded-full"></div>
                            <span class="text-[8px] font-mono uppercase text-[#A3A3A3] tracking-widest">Expected</span>
                        </div>
                    </div>
                </div>
                <div class="h-64">
                    <Bar v-if="chart_data?.revenue_stream" :data="{
                        labels: chart_data.revenue_stream.labels,
                        datasets: [
                            { label: 'Received', data: chart_data.revenue_stream.received, backgroundColor: '#10b981', borderRadius: 4 },
                            { label: 'Expected', data: chart_data.revenue_stream.expected, backgroundColor: '#27272a', borderRadius: 4 }
                        ]
                    }" :options="baseOptions" />
                </div>
            </div>
            <div class="bg-[#171717] border border-[#242424] p-8 rounded-2xl shadow-2xl">
                 <h3 class="text-[10px] font-display font-bold uppercase tracking-[0.3em] text-white mb-10">Portfolio Integrity</h3>
                 <div class="h-64 flex items-center justify-center">
                    <Doughnut v-if="chart_data?.revenue_by_status" :data="{
                        labels: chart_data.revenue_by_status.labels,
                        datasets: [{
                            data: chart_data.revenue_by_status.values,
                            backgroundColor: ['#f97316', '#10b981', '#3b82f6', '#ef4444'],
                            borderWidth: 0,
                            hoverOffset: 12
                        }]
                    }" :options="{ responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { display: false } } }" />
                 </div>
                 <div class="mt-8 space-y-3">
                    <div v-for="(label, i) in chart_data?.revenue_by_status.labels" :key="label" class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full" :style="{ backgroundColor: ['#f97316', '#10b981', '#3b82f6', '#ef4444'][i] }"></div>
                            <span class="text-[9px] font-mono uppercase text-[#A3A3A3] tracking-widest">{{ label }}</span>
                        </div>
                        <span class="text-[9px] font-mono font-bold text-white">{{ formatCurrency(chart_data?.revenue_by_status.values[i]) }}</span>
                    </div>
                 </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div v-for="stat in [
                { label: 'Total Received', val: formatCurrency(stats?.total_received), icon: '📈', color: 'text-emerald-500' },
                { label: 'Expected Revenue', val: formatCurrency(stats?.total_expected), icon: '📊', color: 'text-white' },
                { label: 'Pending Arrears', val: formatCurrency(stats?.total_pending), icon: '⏳', color: 'text-red-500' },
            ]" :key="stat.label" class="bg-[#171717] border border-[#242424] p-8 rounded-xl shadow-2xl relative overflow-hidden group">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-[9px] font-display font-bold uppercase tracking-[0.3em] text-[#737373]">{{ stat.label }}</span>
                    <span class="text-xl">{{ stat.icon }}</span>
                </div>
                <h3 class="text-3xl font-display font-bold tracking-tight" :class="stat.color">{{ stat.val }}</h3>
                <div v-if="stat.label === 'Total Received'" class="mt-4">
                    <div class="w-full bg-[#0D0D0D] h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full" :style="{ width: stats?.avg_collection_rate + '%' }"></div>
                    </div>
                    <p class="text-[8px] font-mono text-[#737373] uppercase tracking-widest mt-2">Collection Rate: {{ stats?.avg_collection_rate?.toFixed(1) }}%</p>
                </div>
            </div>
        </div>

        <div class="bg-[#171717] border border-[#242424] shadow-2xl rounded-2xl overflow-hidden">
            <div class="p-8 border-b border-[#242424] flex justify-between items-center">
                <h3 class="text-[10px] font-display font-bold uppercase tracking-[0.3em] text-white">Revenue Sources Protocol</h3>
                <span class="text-[9px] font-mono text-[#737373]">{{ portfolios?.length || 0 }} Projects Active</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#0D0D0D]/50 text-[9px] font-display font-bold uppercase tracking-widest text-[#737373] border-b border-[#242424]">
                            <th class="px-8 py-5">Project / Client Node</th>
                            <th class="px-8 py-5 text-center">Protocol Status</th>
                            <th class="px-8 py-5 text-right">Expected</th>
                            <th class="px-8 py-5 text-right">Inflow (Rec.)</th>
                            <th class="px-8 py-5 text-right">Delta (Pending)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#242424]">
                        <tr v-for="p in portfolios" :key="p.id" class="hover:bg-[#242424]/40 transition-colors">
                            <td class="px-8 py-5">
                                <p class="text-xs font-display font-bold text-white uppercase tracking-tight">{{ p.title }}</p>
                                <p class="text-[8px] text-[#737373] font-mono uppercase mt-1">ID: #{{ p.id }} · {{ new Date(p.created_at).toLocaleDateString() }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-3 py-1 bg-[#242424] border border-[#383838] text-[8px] font-mono uppercase tracking-widest text-[#A3A3A3] rounded-lg">
                                    {{ p.execution_status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right font-mono text-xs text-[#A3A3A3]">
                                {{ formatCurrency(p.expected_revenue) }}
                            </td>
                            <td class="px-8 py-5 text-right font-mono text-xs text-emerald-400 font-bold">
                                {{ formatCurrency(p.received_payment) }}
                            </td>
                            <td class="px-8 py-5 text-right font-mono text-xs font-bold" :class="p.pending_payment > 0 ? 'text-red-400' : 'text-[#525252]'">
                                {{ formatCurrency(p.pending_payment) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
