<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import SectionBuilder from '@/Components/Admin/SectionBuilder.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    page: Object
});

const form = useForm({
    title: props.page?.title || '',
    slug: props.page?.slug || '',
    status: props.page?.status || 'draft',
    sections: props.page?.sections || [],
});

const submit = () => {
    if (props.page) {
        form.transform(data => ({
            ...data,
            _method: 'PUT'
        })).post(route('admin.pages.update', props.page.id), {
            forceFormData: true,
        });
    } else {
        form.post(route('admin.pages.store'), {
            forceFormData: true,
        });
    }
};

const getPagePublicUrl = (slug) => {
    if (!slug) return '/';
    if (slug === 'overview' || slug === 'home') return '/';
    if (slug === 'architect' || slug === 'about') return '/about';
    if (slug === 'capabilities' || slug === 'services') return '/services';
    if (slug === 'project' || slug === 'portfolio' || slug === 'projects') return '/projects';
    if (slug === 'contact') return '/contact';
    if (slug === 'faqs' || slug === 'faq') return '/faqs';
    if (slug === 'privacy-policy') return '/privacy-policy';
    if (slug === 'terms-and-conditions') return '/terms-and-conditions';
    if (slug === 'footer') return '/#footer';
    return `/p/${slug}`;
};
</script>

<template>
    <AdminLayout>
        <Head :title="page ? 'Modify Structure' : 'Construct New Page'" />

        <ModuleHeader :title="page ? `Edit Page: ${page.title}` : 'New Page Assembly'">
            <template #subtitle>
                <Link :href="route('admin.pages.index')" class="inline-flex items-center gap-2 text-xs font-mono text-[#A3A3A3] hover:text-[#E05A1B] transition-colors mt-1">
                    ← Return to Pages Overview
                </Link>
            </template>
        </ModuleHeader>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-10">
            <!-- Content & Sections -->
            <div class="lg:col-span-3 space-y-8">
                <div class="bg-[#171717] border border-[#242424] p-8 sm:p-10 space-y-8 shadow-2xl rounded-2xl">
                    <h3 class="text-xs font-mono font-bold uppercase tracking-[0.3em] text-[#737373] border-b border-[#242424] pb-3">Primary Page Identity</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Administrative Title</label>
                            <input v-model="form.title" type="text" class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] text-white font-display font-bold uppercase tracking-tight px-5 py-3.5 focus:ring-0 transition-all rounded-xl">
                            <p v-if="form.errors.title" class="text-xs font-mono text-red-400 mt-2 uppercase">{{ form.errors.title }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Structural Slug (URL Vector)</label>
                            <input v-model="form.slug" type="text" class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] text-white font-mono px-5 py-3.5 focus:ring-0 transition-all rounded-xl" placeholder="my-custom-page">
                            <p v-if="form.errors.slug" class="text-xs font-mono text-red-400 mt-2 uppercase">{{ form.errors.slug }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#171717] border border-[#242424] p-8 sm:p-10 shadow-2xl rounded-2xl">
                    <div class="flex items-center justify-between border-b border-[#242424] pb-4 mb-8">
                        <h3 class="text-xs font-mono font-bold uppercase tracking-[0.3em] text-[#737373]">Structural Components</h3>
                        <span class="text-xs font-mono font-bold text-[#E05A1B]">Total Nodes: {{ form.sections.length }}</span>
                    </div>
                    <SectionBuilder v-model="form.sections" />
                </div>
            </div>

            <!-- Sidebar Controls -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Deployment Status Card -->
                <div class="bg-[#171717] border border-[#242424] shadow-2xl sticky top-24 flex flex-col w-full max-w-full overflow-hidden rounded-2xl">
                    <div class="p-5 border-b border-[#242424] bg-[#141414]">
                        <h3 class="text-xs font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3]">Deployment Status</h3>
                    </div>
                    
                    <div class="p-6 space-y-6 flex flex-col w-full box-border">
                        <div class="space-y-3 flex flex-col w-full">
                            <label v-for="status in ['draft', 'published', 'archived']" :key="status" 
                                class="flex items-center gap-3.5 p-3.5 bg-[#121212] border border-[#242424] cursor-pointer group hover:border-[#E05A1B]/50 transition-all rounded-xl w-full box-border">
                                <input type="radio" v-model="form.status" :value="status" 
                                    class="w-4 h-4 bg-[#171717] border-[#383838] text-[#E05A1B] focus:ring-0 cursor-pointer shrink-0">
                                <span class="text-xs font-mono font-bold uppercase tracking-wider text-[#A3A3A3] group-hover:text-white transition-colors truncate">{{ status }}</span>
                            </label>
                        </div>

                        <div class="space-y-3 flex flex-col w-full pt-2">
                            <button type="submit" :disabled="form.processing" class="w-full bg-[#E05A1B] hover:bg-[#F97316] py-3.5 text-xs font-display font-bold uppercase tracking-widest text-[#0D0D0D] rounded-xl shadow-lg shadow-[#E05A1B]/20 transition-all active:scale-95 disabled:opacity-50">
                                {{ form.processing ? 'Syncing...' : 'Commit Structure' }}
                            </button>

                            <a v-if="page" :href="getPagePublicUrl(page.slug)" target="_blank" class="w-full border border-[#242424] hover:border-[#E05A1B] bg-[#141414] hover:bg-[#202020] py-3.5 flex items-center justify-center text-xs font-display font-bold uppercase tracking-widest text-[#F3F1EC] rounded-xl transition-all">
                                Live Preview ↗
                            </a>
                        </div>
                        
                        <div v-if="form.recentlySuccessful" class="p-3 bg-emerald-950/40 border border-emerald-800/40 text-center rounded-xl">
                            <p class="text-[10px] font-mono font-bold text-emerald-400 uppercase tracking-widest animate-pulse">
                                Synchronization Complete
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-5 border-t border-[#242424] bg-[#141414]">
                        <h4 class="text-[10px] font-mono font-bold text-[#E05A1B] uppercase tracking-[0.2em] mb-2 text-center">Metadata Analysis</h4>
                        <p class="text-[10px] text-[#737373] font-mono uppercase tracking-wider leading-relaxed text-center">
                            Search engine optimization vectors are auto-injected based on primary content segments.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
