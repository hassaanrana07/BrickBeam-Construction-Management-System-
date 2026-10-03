<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    projects: Array
});

const search = ref('');

const filteredProjects = computed(() => {
    if (!search.value) return props.projects;
    const lowerSearch = search.value.toLowerCase();
    return props.projects.filter(project => 
        project.title.toLowerCase().includes(lowerSearch) || 
        (project.location && project.location.toLowerCase().includes(lowerSearch)) ||
        (project.project_type && project.project_type.toLowerCase().includes(lowerSearch))
    );
});

const formatCurrency = (val) => {
    if (val === null || val === undefined) return '$0';
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0
    }).format(val);
};

const deleteProject = (id) => {
    if (confirm('Decommission this project permanently?')) {
        router.delete(route('admin.portfolios.destroy', id), {
            preserveScroll: true,
            preserveState: true,
        });
    }
};

const selectedIds = ref([]);
const toggleSelectAll = (event) => {
    if (event.target.checked) {
        selectedIds.value = filteredProjects.value.map(p => p.id);
    } else {
        selectedIds.value = [];
    }
};

const bulkDownload = () => {
    if (selectedIds.value.length === 0) return;
    
    // Using a form submission for POST request to handle many IDs and avoid 419/414 errors
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = route('admin.portfolios.bulk-pdf');
    form.target = '_blank';
    
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);
    }
    
    selectedIds.value.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
};
</script>

<template>
    <AdminLayout>
        <Head title="Project Matrix" />

        <ModuleHeader 
            title="Portfolio Management" 
            v-model:search="search"
        >
            <template #subtitle>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mt-2">Centralized command for infrastructure projects & financial auditing.</p>
            </template>
            <template #actions>
                <div class="flex gap-4">
                    <button 
                        @click="bulkDownload"
                        v-if="selectedIds.length > 0"
                        class="px-6 py-3 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all rounded-xl shadow-lg shadow-slate-900/10"
                    >
                        <span class="flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                             Bulk Audit ({{ selectedIds.length }})
                        </span>
                    </button>
                    <Link :href="route('admin.portfolios.create')" class="px-8 py-3 bg-primary text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-900 transition-all shadow-lg shadow-primary/20 active:scale-95 flex items-center justify-center gap-2 border border-transparent h-full whitespace-nowrap rounded-xl">
                        <span>+</span> New Deployment
                    </Link>
                </div>
            </template>
        </ModuleHeader>

        <div class="bg-[#171717] border border-[#242424] p-8 space-y-6 shadow-2xl rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead>
                        <tr class="bg-[#141414] border-b border-[#242424]">
                            <th class="px-6 py-5 w-10">
                                <input type="checkbox" @change="toggleSelectAll" :checked="selectedIds.length === filteredProjects.length && filteredProjects.length > 0" class="bg-[#0D0D0D] border-[#242424] text-[#E05A1B] focus:ring-0 rounded cursor-pointer">
                            </th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373]">Asset Identity</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373] text-center">Revenue / Budget</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373] text-center">Execution Status</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373]">Status Node</th>
                            <th class="px-6 py-5 text-[9px] font-mono font-bold uppercase tracking-[0.25em] text-[#737373] text-right">Directives</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#242424]">
                        <tr v-for="project in filteredProjects" :key="project.id" class="hover:bg-[#202020] transition-colors group">
                            <td class="px-6 py-5 text-center">
                                <input type="checkbox" v-model="selectedIds" :value="project.id" class="bg-[#0D0D0D] border-[#242424] text-[#E05A1B] focus:ring-0 rounded cursor-pointer">
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-display font-bold text-xs uppercase tracking-tight text-white group-hover:text-[#E05A1B] transition-colors">{{ project.title }}</div>
                                <div class="text-[9px] text-[#737373] font-mono uppercase tracking-wider mt-1">{{ project.location || 'GLOBAL_NODE' }} · {{ project.project_type }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="text-xs font-mono font-bold text-emerald-400">{{ formatCurrency(project.received_payment) }}</div>
                                <div class="text-[9px] text-[#737373] font-mono mt-0.5">Budget: {{ formatCurrency(project.total_budget) }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span :class="[
                                    project.execution_status === 'Completed' ? 'text-emerald-400 bg-emerald-950/40 border-emerald-500/30' : 'text-[#E05A1B] bg-[#E05A1B]/10 border-[#E05A1B]/20',
                                    'text-[9px] font-mono font-bold px-3 py-1 border rounded-md uppercase tracking-wider'
                                ]">{{ project.execution_status }}</span>
                                <div v-if="project.execution_status === 'Completed' && project.completion_date" class="text-[8px] text-[#737373] mt-1 font-mono uppercase">End: {{ new Date(project.completion_date).toLocaleDateString() }}</div>
                                <div v-else-if="project.start_date" class="text-[8px] text-[#737373] mt-1 font-mono uppercase">Start: {{ new Date(project.start_date).toLocaleDateString() }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2.5">
                                    <div :class="[
                                        project.status === 'published' ? 'bg-emerald-400 shadow-md shadow-emerald-400/40' : 'bg-[#383838]',
                                        'w-2 h-2 rounded-full'
                                    ]"></div>
                                    <span :class="[
                                        project.status === 'published' ? 'text-white' : 'text-[#737373]',
                                        'text-[9px] font-mono font-bold uppercase tracking-wider'
                                    ]">{{ project.status }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right space-x-4">
                                <a :href="route('admin.portfolios.pdf', project.id)" target="_blank" class="text-[9px] font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-[#E05A1B] transition-colors">Report</a>
                                <Link :href="route('admin.portfolios.edit', project.id)" class="text-[9px] font-display font-bold uppercase tracking-wider text-[#A3A3A3] hover:text-white transition-colors">Modify</Link>
                                <button @click="deleteProject(project.id)" class="text-[9px] font-display font-bold uppercase tracking-wider text-red-400 hover:text-red-300 transition-colors">Purge</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Empty State -->
                <div v-if="filteredProjects.length === 0" class="py-24 flex flex-col items-center justify-center text-center bg-[#141414] rounded-xl border border-[#242424]">
                    <div class="w-12 h-12 bg-[#171717] border border-[#242424] flex items-center justify-center mb-4 rounded-xl">
                        <span class="text-[#525252] text-xl font-bold">∅</span>
                    </div>
                    <p class="text-[10px] font-mono font-bold uppercase tracking-widest text-[#737373]">No architectural assets archived in matrix.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
