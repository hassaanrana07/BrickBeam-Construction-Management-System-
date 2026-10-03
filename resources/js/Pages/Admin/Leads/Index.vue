<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    leads: Array
});

const search = ref('');

const filteredLeads = computed(() => {
    if (!search.value) return props.leads;
    const lowerSearch = search.value.toLowerCase();
    return props.leads.filter(lead => 
        lead.name.toLowerCase().includes(lowerSearch) || 
        lead.email.toLowerCase().includes(lowerSearch) ||
        (lead.status && lead.status.toLowerCase().includes(lowerSearch))
    );
});

const getScoreColor = (score) => {
    if (score >= 70) return 'text-green-600';
    if (score >= 40) return 'text-primary';
    return 'text-slate-400';
};
</script>

<template>
    <AdminLayout>
        <Head title="Lead Pipeline" />

        <ModuleHeader 
            title="Lead Infrastructure"
            v-model:search="search"
        >
            <template #subtitle>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mt-2 italic">
                    Monitoring {{ leads.length }} high-intent construction inquiries across all channels.
                </p>
            </template>
        </ModuleHeader>

        <div class="bg-[#171717] border border-[#242424] shadow-2xl rounded-2xl overflow-hidden p-6 sm:p-8 space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#141414] border-b border-[#242424]">
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373]">Contact Identity</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373] text-center">Source Channel</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373] text-center">Lead Score</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373] text-center">Status Node</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373] text-right">Verification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#242424]">
                        <tr v-for="lead in filteredLeads" :key="lead.id" class="hover:bg-[#202020] transition-colors group cursor-pointer" @click="$inertia.visit(route('admin.leads.show', lead.id))">
                            <td class="px-6 py-5">
                                <div class="font-display font-bold text-xs uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">{{ lead.name }}</div>
                                <div class="text-[9px] text-[#737373] font-mono uppercase tracking-wider mt-1">{{ lead.company || 'Enterprise Entity' }} · {{ lead.email }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-[9px] font-mono font-bold text-[#E05A1B] border border-[#E05A1B]/20 bg-[#E05A1B]/10 px-3 py-1 uppercase tracking-wider rounded-md">{{ lead.source || 'Direct' }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div :class="[getScoreColor(lead.lead_score), 'text-lg font-mono font-black tracking-tight']">
                                    {{ lead.lead_score || 0 }}
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span :class="[
                                    lead.status === 'won' || lead.status === 'qualified' ? 'text-emerald-400 border-emerald-500/30 bg-emerald-950/40' : (lead.status === 'new' ? 'text-[#E05A1B] border-[#E05A1B]/30 bg-[#E05A1B]/10' : 'text-[#A3A3A3] border-[#383838] bg-[#141414]'),
                                    'px-3 py-1 text-[9px] font-mono font-bold uppercase tracking-wider border rounded-md'
                                ]">{{ lead.status }}</span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <Link :href="route('admin.leads.show', lead.id)" class="text-[9px] font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-white bg-[#242424] px-3.5 py-1.5 hover:bg-[#E05A1B] hover:text-[#0D0D0D] border border-[#383838] transition-all rounded-lg">Audit Data</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Empty State -->
                <div v-if="filteredLeads.length === 0" class="py-24 flex flex-col items-center justify-center text-center bg-[#141414] rounded-xl border border-[#242424]">
                    <div class="w-12 h-12 bg-[#171717] border border-[#242424] flex items-center justify-center mb-4 rounded-xl">
                        <span class="text-[#525252] text-xl font-bold">∅</span>
                    </div>
                    <p class="text-[10px] font-mono font-bold uppercase tracking-widest text-[#737373]">No signals detected in pipeline matrix.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
