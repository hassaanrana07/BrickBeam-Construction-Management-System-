<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    lead: Object
});

const form = useForm({
    status: props.lead.status,
    internal_notes: props.lead.internal_notes || '',
});

const updateLead = () => {
    form.put(route('admin.leads.update', props.lead.id));
};
</script>

<template>
    <AdminLayout>
        <Head :title="`Audit: ${lead.name}`" />

        <ModuleHeader :title="`Lead: ${lead.name}`">
            <template #subtitle>
                <Link :href="route('admin.leads.index')" class="text-[10px] font-mono font-bold text-[#A3A3A3] hover:text-[#E05A1B] uppercase tracking-[0.2em] flex items-center gap-2 mt-2 transition-colors">
                    <span>←</span> Return to Pipeline Overview
                </Link>
            </template>
        </ModuleHeader>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Core Data -->
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-8 shadow-2xl rounded-2xl text-white">
                    <div>
                        <h3 class="text-xs font-display font-bold uppercase tracking-wider text-[#E05A1B] border-b border-[#242424] pb-4 mb-6">Metadata Analysis</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl space-y-1">
                                <p class="text-[9px] font-mono font-bold uppercase tracking-wider text-[#737373]">Email Vector</p>
                                <p class="text-xs font-bold text-white tracking-wide break-all">{{ lead.email }}</p>
                            </div>
                            <div class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl space-y-1" v-if="lead.phone">
                                <p class="text-[9px] font-mono font-bold uppercase tracking-wider text-[#737373]">Communication Node</p>
                                <p class="text-xs font-bold text-white tracking-wide">{{ lead.phone }}</p>
                            </div>
                            <div class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl space-y-1">
                                <p class="text-[9px] font-mono font-bold uppercase tracking-wider text-[#737373]">Acquisition Source</p>
                                <p class="text-xs font-mono font-bold text-[#E05A1B] uppercase tracking-wider">{{ lead.source || 'Direct Channel' }}</p>
                            </div>
                            <div class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl space-y-1">
                                <p class="text-[9px] font-mono font-bold uppercase tracking-wider text-[#737373]">Transmission Timestamp</p>
                                <p class="text-xs font-mono text-[#D4D4D4]">{{ new Date(lead.created_at).toLocaleString() }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-display font-bold uppercase tracking-wider text-[#E05A1B] border-b border-[#242424] pb-4 mb-4">Inquiry Payload</h3>
                        <div class="p-6 bg-[#0D0D0D] border border-[#242424] border-l-4 border-l-[#E05A1B] rounded-xl text-sm font-medium text-[#D4D4D4] leading-relaxed">
                            "{{ lead.message || 'No manual message provided in this transmission.' }}"
                        </div>
                    </div>

                    <div v-if="lead.form_data">
                        <h3 class="text-xs font-display font-bold uppercase tracking-wider text-[#E05A1B] border-b border-[#242424] pb-4 mb-4">Structured Object Data</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div v-for="(val, key) in lead.form_data" :key="key" class="p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                <p class="text-[9px] font-mono font-bold uppercase tracking-wider text-[#737373] mb-1">{{ key }}</p>
                                <p class="text-xs font-mono font-bold text-white">{{ val }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-8 shadow-2xl rounded-2xl sticky top-28 text-white">
                    <div>
                        <h3 class="text-xs font-display font-bold uppercase tracking-wider text-[#E05A1B] mb-4">Pipeline Workflow</h3>
                        <select v-model="form.status" @change="updateLead" class="w-full bg-[#0D0D0D] border border-[#242424] text-white text-xs font-mono font-bold uppercase tracking-wider py-3.5 px-4 rounded-xl focus:ring-0 focus:border-[#E05A1B] transition-colors">
                            <option v-for="status in ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost']" :key="status" :value="status">
                                {{ status }}
                            </option>
                        </select>
                    </div>

                    <div class="border-t border-[#242424] pt-6">
                        <h3 class="text-xs font-display font-bold uppercase tracking-wider text-[#E05A1B] mb-4">Lead Scoring Matrix</h3>
                        <div class="flex items-center gap-5 p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                            <div class="text-4xl font-mono font-black tracking-tight text-white">{{ lead.lead_score || 0 }}</div>
                            <div class="text-[9px] font-mono font-bold uppercase tracking-wider text-[#A3A3A3] leading-relaxed">
                                {{ lead.lead_score >= 50 ? 'HIGH PRIORITY VECTOR' : 'STANDARD INQUIRY' }}
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[#242424] pt-6">
                        <h3 class="text-xs font-display font-bold uppercase tracking-wider text-[#E05A1B] mb-4">Internal Strategic Notes</h3>
                        <textarea v-model="form.internal_notes" @blur="updateLead" rows="5" class="w-full bg-[#0D0D0D] border border-[#242424] text-[#D4D4D4] text-xs font-mono leading-relaxed p-4 rounded-xl focus:ring-0 focus:border-[#E05A1B] transition-colors placeholder-[#525252]" placeholder="strategic observations..."></textarea>
                        <p class="text-[8px] font-mono text-[#737373] uppercase tracking-wider mt-2 text-right flex items-center justify-end gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Auto-saving active
                        </p>
                    </div>

                    <div class="border-t border-[#242424] pt-6">
                        <h3 class="text-xs font-display font-bold uppercase tracking-wider text-[#737373] mb-4">Infrastructure Context</h3>
                        <div class="space-y-4 text-xs font-mono">
                            <div class="space-y-1">
                                <p class="text-[9px] font-bold text-[#737373] uppercase">Origin IP Address</p>
                                <code class="text-xs font-bold text-[#E05A1B] bg-[#0D0D0D] px-2 py-1 border border-[#242424] rounded inline-block">{{ lead.ip_address || '127.0.0.1' }}</code>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[9px] font-bold text-[#737373] uppercase">Client User-Agent</p>
                                <p class="text-[9px] text-[#737373] truncate">{{ lead.user_agent || 'Standard Desktop Client' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
