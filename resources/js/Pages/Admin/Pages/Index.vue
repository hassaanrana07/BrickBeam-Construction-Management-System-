<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    pages: Array
});

const search = ref('');

const filteredPages = computed(() => {
    if (!search.value) return props.pages;
    const lowerSearch = search.value.toLowerCase();
    return props.pages.filter(page => 
        page.title.toLowerCase().includes(lowerSearch) || 
        page.slug.toLowerCase().includes(lowerSearch)
    );
});

const deletePage = (id) => {
    if (confirm('Deconstruct this structural node permanently?')) {
        router.delete(route('admin.pages.destroy', id), {
            preserveScroll: true,
            preserveState: true,
        });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="CMS Pages | Operational Core" />

        <ModuleHeader 
            title="CMS Pages" 
            actionText="Construct New Page" 
            :actionRoute="route('admin.pages.create')"
            v-model:search="search"
        >
            <template #subtitle>
                <p class="text-xs font-mono text-[#A3A3A3] mt-1">Manage structural assets and content sections for the public construction portal.</p>
            </template>
        </ModuleHeader>

        <div class="bg-[#171717] border border-[#242424] shadow-2xl rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left table-fixed">
                    <thead>
                        <tr class="bg-[#121212] border-b border-[#242424]">
                            <th class="px-8 py-5 text-[10px] font-mono uppercase tracking-[0.2em] text-[#737373] w-1/3">Deployment Node (Title)</th>
                            <th class="px-8 py-5 text-[10px] font-mono uppercase tracking-[0.2em] text-[#737373] w-1/4">Sector (Slug)</th>
                            <th class="px-8 py-5 text-[10px] font-mono uppercase tracking-[0.2em] text-[#737373] w-1/6">Status</th>
                            <th class="px-8 py-5 text-[10px] font-mono uppercase tracking-[0.2em] text-[#737373] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#242424]/60">
                        <tr v-for="page in filteredPages" :key="page.id" class="group hover:bg-[#202020] transition-colors">
                            <td class="px-8 py-5">
                                <Link :href="route('admin.pages.edit', page.id)" class="text-sm font-display font-bold text-white uppercase tracking-tight group-hover:text-[#E05A1B] transition-colors block truncate">
                                    {{ page.title }}
                                </Link>
                                <p class="text-[9px] font-mono text-[#525252] mt-1">NODE ID: {{ page.id.toString().padStart(4, '0') }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs font-mono text-[#E05A1B] bg-[#E05A1B]/10 border border-[#E05A1B]/20 px-3 py-1 rounded-lg inline-block">/{{ page.slug }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span :class="[
                                    page.status === 'published' ? 'text-emerald-400 border-emerald-800/40 bg-emerald-950/40' : 'text-[#E5A93C] border-[#E5A93C]/20 bg-[#E5A93C]/10',
                                    'px-3 py-1 text-[9px] font-mono uppercase tracking-widest border inline-block rounded-lg'
                                ]">{{ page.status }}</span>
                            </td>
                            <td class="px-8 py-5 text-right space-x-3">
                                <Link :href="route('admin.pages.edit', page.id)" class="inline-flex items-center px-3 py-1.5 bg-[#242424] hover:bg-[#2e2e2e] text-xs font-display font-bold text-[#A3A3A3] hover:text-white uppercase tracking-wider rounded-lg transition-all">Modify</Link>
                                <button @click="deletePage(page.id)" class="inline-flex items-center px-3 py-1.5 bg-red-950/20 hover:bg-red-950/50 text-xs font-display font-bold text-red-400 hover:text-red-300 uppercase tracking-wider rounded-lg transition-all">Purge</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div v-if="filteredPages.length === 0" class="py-20 text-center border-t border-[#242424] bg-[#141414]">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#1F1F1F] mb-3 text-[#525252]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <p class="text-xs font-mono uppercase tracking-widest text-[#737373]">No organizational nodes detected.</p>
            </div>
        </div>
        
        <div class="mt-8 flex justify-between items-center text-[10px] font-mono text-[#525252] uppercase tracking-widest">
            <span>SYSTEM LOG: STRUCTURAL_INTEGRITY_CHECK_PASS</span>
            <span>V.12.4.0</span>
        </div>
    </AdminLayout>
</template>
