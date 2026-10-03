<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    expenses: Array,
    portfolios: Array,
    vendors: Array,
    stats: Object,
});

const form = useForm({
    portfolio_id: '',
    vendor_id: '',
    amount: '',
    category: 'materials',
    due_date: '',
    invoice_number: '',
    status: 'pending',
});

const showCreateModal = ref(false);

const submit = () => {
    form.post(route('admin.expenses.store'), {
        onSuccess: () => {
            showCreateModal.value = false;
            form.reset();
        }
    });
};

const formatCurrency = (val) => new Intl.NumberFormat('en-PK', { style: 'currency', currency: 'PKR' }).format(val);
const getStatusColor = (s) => {
    const colors = { paid: 'text-emerald-500', pending: 'text-orange-500', disputed: 'text-red-500' };
    return colors[s] || 'text-zinc-500';
};
</script>

<template>
    <AdminLayout>
        <Head title="Expense Control | Operational Core" />

        <ModuleHeader title="Financial Expense Matrix">
            <template #actions>
                <div class="flex flex-wrap gap-3">
                    <button @click="showCreateModal = true" class="px-5 py-2.5 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] text-xs font-display font-bold uppercase tracking-wider rounded-xl shadow-lg shadow-[#E05A1B]/20 transition-all active:scale-95">
                        + Log New Expense
                    </button>
                    <a :href="route('admin.expenses.export-csv')" class="px-5 py-2.5 bg-[#171717] hover:bg-[#242424] border border-[#242424] hover:border-[#525252] text-xs font-mono font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-white rounded-xl transition-all">
                        Export CSV
                    </a>
                    <a :href="route('admin.expenses.export-pdf')" target="_blank" class="px-5 py-2.5 bg-[#171717] hover:bg-[#242424] border border-[#242424] hover:border-[#525252] text-xs font-mono font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-white rounded-xl transition-all">
                        Export PDF
                    </a>
                </div>
            </template>
        </ModuleHeader>

        <!-- KPI Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div v-for="(val, label) in {
                'Total Outflow': formatCurrency(stats?.total_outflow || 0),
                'Pending AP': formatCurrency(stats?.pending_ap || 0),
                'Monthly Burn': formatCurrency(stats?.monthly_burn || 0),
                'Disputed Claims': formatCurrency(stats?.disputed_amount || 0)
            }" :key="label" class="bg-[#171717] border border-[#242424] p-6 sm:p-7 rounded-2xl shadow-xl corner-crosshair">
                <p class="text-[10px] font-mono uppercase tracking-[0.2em] text-[#737373] mb-2">{{ label }}</p>
                <p class="text-2xl sm:text-3xl font-display font-extrabold text-white tracking-tight">{{ val }}</p>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="bg-[#171717] border border-[#242424] rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#121212] text-[10px] font-mono uppercase tracking-[0.2em] text-[#737373] border-b border-[#242424]">
                            <th class="px-8 py-5">Reference</th>
                            <th class="px-8 py-5">Project Nodes</th>
                            <th class="px-8 py-5">Vendor/Service</th>
                            <th class="px-8 py-5">Magnitude</th>
                            <th class="px-8 py-5">Protocol Status</th>
                            <th class="px-8 py-5 text-right">Audit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#242424]/60">
                        <tr v-for="exp in expenses" :key="exp.id" class="hover:bg-[#202020] transition-colors group text-[#F3F1EC]">
                            <td class="px-8 py-5">
                                <p class="text-xs font-mono font-bold text-white uppercase">{{ exp.invoice_number || 'STUB-#' + exp.id }}</p>
                                <p class="text-[9px] font-mono text-[#737373] uppercase mt-0.5">{{ exp.category }}</p>
                            </td>
                            <td class="px-8 py-5 text-xs font-display font-bold text-[#A3A3A3] uppercase">{{ exp.portfolio?.title || 'GENERAL PROJECT' }}</td>
                            <td class="px-8 py-5 text-xs font-mono text-white uppercase">{{ exp.vendor?.name || 'Direct Procurement' }}</td>
                            <td class="px-8 py-5 text-xs font-mono font-bold text-[#E05A1B]">{{ formatCurrency(exp.amount) }}</td>
                            <td class="px-8 py-5">
                                <span :class="getStatusColor(exp.status)" class="text-[10px] font-mono font-bold uppercase tracking-wider">{{ exp.status }}</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <button class="text-[10px] font-mono font-bold text-[#737373] hover:text-white uppercase tracking-wider transition-colors">Archive</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div v-if="showCreateModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-black/80 backdrop-blur-md">
            <div class="bg-[#171717] border border-[#242424] w-full max-w-xl p-8 sm:p-10 rounded-2xl shadow-2xl text-white">
                <div class="flex justify-between items-center border-b border-[#242424] pb-4 mb-6">
                    <h3 class="text-lg font-display font-bold uppercase tracking-tight text-white">New Expense Protocol</h3>
                    <button @click="showCreateModal = false" class="text-[#737373] hover:text-white text-xl leading-none">&times;</button>
                </div>
                <form @submit.prevent="submit" class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-mono font-bold uppercase tracking-wider text-[#A3A3A3]">Project Nodes</label>
                            <select v-model="form.portfolio_id" required class="w-full bg-[#121212] border border-[#242424] text-white p-3 text-xs font-mono uppercase focus:border-[#E05A1B] focus:ring-0 rounded-xl transition-all">
                                <option value="" disabled>Select Project</option>
                                <option v-for="p in portfolios" :key="p.id" :value="p.id">{{ p.title }}</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-mono font-bold uppercase tracking-wider text-[#A3A3A3]">Vendor/Entity</label>
                            <select v-model="form.vendor_id" class="w-full bg-[#121212] border border-[#242424] text-white p-3 text-xs font-mono uppercase focus:border-[#E05A1B] focus:ring-0 rounded-xl transition-all">
                                <option value="">Direct Procurement</option>
                                <option v-for="v in vendors" :key="v.id" :value="v.id">{{ v.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-mono font-bold uppercase tracking-wider text-[#A3A3A3]">Financial Magnitude (PKR)</label>
                            <input v-model="form.amount" type="number" step="0.01" required class="w-full bg-[#121212] border border-[#242424] text-white p-3 text-xs font-mono focus:border-[#E05A1B] focus:ring-0 rounded-xl transition-all placeholder-[#525252]" placeholder="50000.00">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-mono font-bold uppercase tracking-wider text-[#A3A3A3]">Classification</label>
                            <select v-model="form.category" class="w-full bg-[#121212] border border-[#242424] text-white p-3 text-xs font-mono uppercase focus:border-[#E05A1B] focus:ring-0 rounded-xl transition-all">
                                <option value="labor">Personnel/Labor</option>
                                <option value="materials">Raw Materials</option>
                                <option value="equipment">Hardware/Equipment</option>
                                <option value="overhead">Operational Overhead</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-4 pt-4 border-t border-[#242424]">
                        <button type="button" @click="showCreateModal = false" class="flex-1 py-3 text-xs font-mono uppercase text-[#737373] hover:text-white transition-colors">Abort</button>
                        <button type="submit" :disabled="form.processing" class="flex-1 py-3 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] text-xs font-display font-bold uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-[#E05A1B]/20 active:scale-95 disabled:opacity-50">Commit Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
