<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    project: Object
});

const imagePreview = ref(null);
const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.featured_image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const form = useForm({
    title: props.project?.title || '',
    slug: props.project?.slug || '',
    short_description: props.project?.short_description || '',
    project_type: props.project?.project_type || 'Residential',
    location: props.project?.location || '',
    budget_range: props.project?.budget_range || '',
    total_budget: props.project?.total_budget || 0,
    expected_revenue: props.project?.expected_revenue || 0,
    received_payment: props.project?.received_payment || 0,
    execution_status: props.project?.execution_status || 'In Progress',
    start_date: props.project?.start_date || '',
    completion_date: props.project?.completion_date || '',
    status: props.project?.status || 'published',
    is_featured: props.project?.is_featured || false,
    is_public: props.project?.is_public ?? true,
    is_public_visible: props.project?.is_public_visible ?? true,
    featured_image: null,
    image_url: props.project?.image_url || '',
    // Case Study fields
    case_study_category: props.project?.case_study_category || '',
    case_study_scope: props.project?.case_study_scope || '',
    case_study_sector: props.project?.case_study_sector || '',
    cs_phase_1: props.project?.cs_phase_1 || '',
    cs_phase_2: props.project?.cs_phase_2 || '',
    cs_phase_3: props.project?.cs_phase_3 || '',
    cs_phase_4: props.project?.cs_phase_4 || '',
    cs_phase_5: props.project?.cs_phase_5 || '',
    cs_duration_weeks: props.project?.cs_duration_weeks || 0,
    cs_team: props.project?.cs_team || '',
    cs_total_value: props.project?.cs_total_value || '',
    // Structure Analysis
    structural_features: props.project?.structural_features || [],
    base_structure: props.project?.base_structure || '',
    foundation_type: props.project?.foundation_type || '',
    total_floors: props.project?.total_floors || 0,
    floor_composition: props.project?.floor_composition || '',
    capabilities: props.project?.capabilities || [],
    functional_features: props.project?.functional_features || [],
    technology_used: props.project?.technology_used || '',
    construction_technology: props.project?.construction_technology || '',
    tools_used: props.project?.tools_used || [],
    framework_type: props.project?.framework_type || '',
});

const newStrFeature = ref('');
const addStrFeature = () => { if (newStrFeature.value.trim()) { form.structural_features.push(newStrFeature.value.trim()); newStrFeature.value = ''; } };

const newCapability = ref('');
const addCapability = () => { if (newCapability.value.trim()) { form.capabilities.push(newCapability.value.trim()); newCapability.value = ''; } };

const newFuncFeature = ref('');
const addFuncFeature = () => { if (newFuncFeature.value.trim()) { form.functional_features.push(newFuncFeature.value.trim()); newFuncFeature.value = ''; } };

const newTool = ref('');
const addTool = () => { if (newTool.value.trim()) { form.tools_used.push(newTool.value.trim()); newTool.value = ''; } };

const removeBullet = (arr, i) => arr.splice(i, 1);

const calculatedPending = computed(() => {
    return (form.expected_revenue || 0) - (form.received_payment || 0);
});

const calculatedProfit = computed(() => {
    return (form.received_payment || 0) - (form.total_budget || 0);
});

const formatCurrency = (val) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(val || 0);
};

const submit = () => {
    if (props.project) {
        form.transform(data => ({
            ...data,
            _method: 'PUT'
        })).post(route('admin.portfolios.update', props.project.id), {
            forceFormData: true,
        });
    } else {
        form.post(route('admin.portfolios.store'), {
            forceFormData: true,
        });
    }
};
</script>

<template>
    <AdminLayout>
        <Head :title="project ? 'Audit Project Logic' : 'Initiate New Deployment'" />

        <ModuleHeader :title="project ? `Project: ${project.title}` : 'New Project Deployment'">
            <template #subtitle>
                <Link :href="route('admin.portfolios.index')" class="text-[10px] font-black text-zinc-400 hover:text-primary uppercase tracking-[0.3em] flex items-center gap-2 mt-2 transition-colors">
                    <span>←</span> Return to Project Library
                </Link>
            </template>
        </ModuleHeader>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Structural Identity -->
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-8 shadow-xl rounded-2xl text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-primary border-b border-[#242424] pb-4">Structural Identity</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Project Label</label>
                            <input v-model="form.title" type="text" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm font-bold uppercase tracking-tight text-white transition-all focus:ring-0 rounded-xl">
                            <p v-if="form.errors.title" class="text-red-500 text-[9px] font-black uppercase mt-1">{{ form.errors.title }}</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Asset Slug (URL)</label>
                            <input v-model="form.slug" type="text" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold tracking-tight text-white transition-all focus:ring-0 placeholder-zinc-600 rounded-xl" placeholder="auto-generated">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Segment Classification</label>
                            <select v-model="form.project_type" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold uppercase tracking-tight text-white transition-all focus:ring-0 rounded-xl">
                                <option>Residential</option>
                                <option>Commercial</option>
                                <option>Infrastructure</option>
                                <option>Industrial</option>
                            </select>
                            <p v-if="form.errors.project_type" class="text-red-500 text-[9px] font-black uppercase mt-1">{{ form.errors.project_type }}</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Execution Status</label>
                            <select v-model="form.execution_status" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold uppercase tracking-tight text-white transition-all focus:ring-0 rounded-xl">
                                <option>Planning</option>
                                <option>In Progress</option>
                                <option>Ongoing</option>
                                <option>Completed</option>
                                <option>On Hold</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Location Vector</label>
                            <input v-model="form.location" type="text" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold uppercase tracking-tight text-white transition-all focus:ring-0 rounded-xl">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Deployment Start Date</label>
                            <input v-model="form.start_date" type="date" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm font-bold tracking-tight text-white transition-all focus:ring-0 rounded-xl">
                        </div>
                        <div class="space-y-2" v-if="form.execution_status === 'Completed'">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Completion Date</label>
                            <input v-model="form.completion_date" type="date" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm font-bold tracking-tight text-white transition-all focus:ring-0 rounded-xl">
                        </div>
                    </div>

                    <div class="space-y-4 pb-8 border-b border-[#242424]">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Featured Global Asset Image</label>
                        <div class="flex flex-col gap-6">
                            <div class="w-full h-72 bg-[#0D0D0D] border border-[#242424] flex items-center justify-center overflow-hidden rounded-2xl group relative shadow-inner">
                                <img v-if="imagePreview || project?.featured_image" :src="imagePreview || project?.featured_image" class="w-full h-full object-cover">
                                <span v-else class="text-zinc-600 text-3xl font-black italic">?</span>
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Target Showcase Image</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-zinc-500">Option 1: File Upload</label>
                                    <label class="block px-6 py-3.5 bg-[#0D0D0D] border border-[#242424] hover:border-primary text-zinc-300 hover:text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all cursor-pointer text-center rounded-xl shadow-sm">
                                        Upload Local Asset
                                        <input type="file" class="hidden" accept="image/*" @change="handleImageChange">
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-zinc-500">Option 2: Image URL</label>
                                    <input v-model="form.image_url" type="url" placeholder="https://example.com/image.jpg" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold text-white transition-all rounded-xl shadow-sm focus:ring-0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Architectural Brief (Short Description)</label>
                        <textarea v-model="form.short_description" rows="3" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm font-medium tracking-tight text-white transition-all focus:ring-0 rounded-xl"></textarea>
                    </div>
                </div>

                <!-- Structure Analysis -->
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-8 shadow-xl rounded-2xl text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-primary border-b border-[#242424] pb-4">Structure Analysis Protocol</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Base Structure</label>
                            <input v-model="form.base_structure" type="text" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold text-white transition-all rounded-xl" placeholder="e.g. Reinforced Concrete">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Foundation Type</label>
                            <input v-model="form.foundation_type" type="text" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold text-white transition-all rounded-xl" placeholder="e.g. Deep Pile Foundation">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Total Floors</label>
                            <input v-model="form.total_floors" type="number" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold text-white transition-all rounded-xl">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Floor Composition</label>
                            <input v-model="form.floor_composition" type="text" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold text-white transition-all rounded-xl" placeholder="e.g. 2 Basement, G+12 Residential">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Structural Features -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Structural Features</label>
                            <div class="space-y-2">
                                <div v-for="(feat, i) in form.structural_features" :key="i" class="flex items-center gap-3 p-3 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                    <span class="flex-1 text-[10px] font-bold text-zinc-300">{{ feat }}</span>
                                    <button type="button" @click="removeBullet(form.structural_features, i)" class="text-red-500 text-xs">✕</button>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <input v-model="newStrFeature" @keydown.enter.prevent="addStrFeature" type="text" placeholder="Add feature..." class="flex-1 bg-[#0D0D0D] border border-[#242424] text-xs text-white rounded-xl p-2.5 focus:border-primary focus:ring-0">
                                <button type="button" @click="addStrFeature" class="bg-[#242424] px-4 text-white text-[9px] font-black uppercase rounded-xl hover:bg-primary transition-colors">Add</button>
                            </div>
                        </div>

                        <!-- Capabilities -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Product Capabilities</label>
                            <div class="space-y-2">
                                <div v-for="(cap, i) in form.capabilities" :key="i" class="flex items-center gap-3 p-3 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                    <span class="flex-1 text-[10px] font-bold text-zinc-300">{{ cap }}</span>
                                    <button type="button" @click="removeBullet(form.capabilities, i)" class="text-red-500 text-xs">✕</button>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <input v-model="newCapability" @keydown.enter.prevent="addCapability" type="text" placeholder="Add capability..." class="flex-1 bg-[#0D0D0D] border border-[#242424] text-xs text-white rounded-xl p-2.5 focus:border-primary focus:ring-0">
                                <button type="button" @click="addCapability" class="bg-[#242424] px-4 text-white text-[9px] font-black uppercase rounded-xl hover:bg-primary transition-colors">Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Architecture -->
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-8 shadow-xl rounded-2xl text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-primary border-b border-[#242424] pb-4">Financial Architecture</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Total Budget</label>
                            <input v-model="form.total_budget" type="number" step="0.01" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-base font-bold text-white transition-all focus:ring-0 rounded-xl">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 mb-2 block">Expected Revenue</label>
                            <input v-model="form.expected_revenue" type="number" step="0.01" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-base font-bold text-white transition-all focus:ring-0 rounded-xl">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-2 block">Received Payment</label>
                            <input v-model="form.received_payment" type="number" step="0.01" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-base font-bold text-primary transition-all focus:ring-0 rounded-xl">
                            <p v-if="form.errors.received_payment" class="text-red-500 text-[9px] font-black uppercase mt-1">{{ form.errors.received_payment }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-[#242424]">
                        <div class="p-5 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-zinc-500 mb-1">Pending Payment (Auto)</p>
                            <p class="text-xl font-bold text-white font-mono">{{ formatCurrency(calculatedPending) }}</p>
                        </div>
                        <div class="p-5 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-zinc-500 mb-1">Project Profit (Auto)</p>
                            <p class="text-xl font-bold font-mono" :class="calculatedProfit >= 0 ? 'text-emerald-500' : 'text-red-500'">{{ formatCurrency(calculatedProfit) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-8 shadow-xl rounded-2xl sticky top-28 text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-zinc-400 border-b border-[#242424] pb-4">Project Controls</h3>
                    
                    <div class="space-y-3">
                        <label class="flex items-center gap-4 p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl cursor-pointer hover:border-primary transition-all group">
                            <input type="checkbox" v-model="form.is_public" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0 rounded">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-300">Internal Visibility</span>
                                <span class="text-[8px] text-zinc-500 font-bold uppercase">System Access</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl cursor-pointer hover:border-primary transition-all group">
                            <input type="checkbox" v-model="form.is_public_visible" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0 rounded">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary">Web Visibility</span>
                                <span class="text-[8px] text-zinc-500 font-bold uppercase">Public Portfolio</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 bg-[#0D0D0D] border border-[#242424] rounded-xl cursor-pointer hover:border-primary transition-all group">
                            <input type="checkbox" v-model="form.is_featured" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0 rounded">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-300">Featured Showcase</span>
                        </label>
                    </div>

                    <div class="space-y-3 border-t border-[#242424] pt-4">
                        <label v-for="status in ['draft', 'published', 'archived']" :key="status" class="flex items-center gap-4 p-3.5 bg-[#0D0D0D] border border-[#242424] rounded-xl cursor-pointer hover:border-[#383838] transition-all">
                            <input type="radio" v-model="form.status" :value="status" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-300">{{ status }}</span>
                        </label>
                    </div>

                    <button type="submit" :disabled="form.processing" class="w-full py-4 bg-primary hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs rounded-xl shadow-lg shadow-primary/20 transition-all disabled:opacity-50">
                        {{ form.processing ? 'Saving Project...' : (project ? 'Update Project' : 'Deploy Project') }}
                    </button>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
