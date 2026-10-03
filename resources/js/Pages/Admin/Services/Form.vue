<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModuleHeader from '@/Components/Admin/ModuleHeader.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ service: Object });

const imagePreview = ref(null);
const technicalLayoutPreview = ref(null);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.featured_image = file;
        form.image_url = '';
        imagePreview.value = URL.createObjectURL(file);
    }
};

const handleLayoutImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.technical_layout_image = file;
        technicalLayoutPreview.value = URL.createObjectURL(file);
    }
};

const parseBullets = (val) => {
    if (!val) return [];
    if (Array.isArray(val)) return val;
    try { return JSON.parse(val); } catch { return []; }
};

const form = useForm({
    title:                   props.service?.title || '',
    slug:                    props.service?.slug || '',
    short_description:       props.service?.short_description || '',
    description:             props.service?.description || '',
    status:                  props.service?.status || 'published',
    is_featured:             props.service?.is_featured || false,
    is_public:               props.service?.is_public ?? true,
    is_public_visible:       props.service?.is_public_visible ?? true,
    featured_image:          null,
    image_url:               props.service?.image_url || '',
    // Capability Scope
    capability_features:     props.service?.capability_features || [],
    capability_deliverables: props.service?.capability_deliverables || [],
    capability_exclusions:   props.service?.capability_exclusions || [],
    capability_tools:        props.service?.capability_tools || [],
    capability_scope_description: props.service?.capability_scope_description || '',
    // Product Structure Analysis
    structural_type:         props.service?.structural_type || '',
    technical_breakdown:     props.service?.technical_breakdown || '',
    materials_used:          props.service?.materials_used || [],
    architecture_layout:     props.service?.architecture_layout || [],
    // Product Structure (Timeline)
    structure_description:   props.service?.structure_description || '',
    timeline_summary:        props.service?.timeline_summary || '',
    phases_details:          props.service?.phases_details || [],
    technical_layout_image:  null,
    // Operations
    operations_description:  props.service?.operations_description || '',
    operations_bullets:      parseBullets(props.service?.operations_bullets),
    operations_timeline:     props.service?.operations_timeline || '',
    operations_team:         props.service?.operations_team || '',
    vacations_description:   props.service?.vacations_description || '',
    vacations_bullets:       parseBullets(props.service?.vacations_bullets),
    vacations_timeline:      props.service?.vacations_timeline || '',
});

const addPhase = () => {
    form.phases_details.push({ title: '', description: '' });
};
const removePhase = (index) => {
    form.phases_details.splice(index, 1);
};

const newFeature = ref('');
const addFeature = () => { if (newFeature.value.trim()) { form.capability_features.push(newFeature.value.trim()); newFeature.value = ''; } };

const newDeliverable = ref('');
const addDeliverable = () => { if (newDeliverable.value.trim()) { form.capability_deliverables.push(newDeliverable.value.trim()); newDeliverable.value = ''; } };

const newExclusion = ref('');
const addExclusion = () => { if (newExclusion.value.trim()) { form.capability_exclusions.push(newExclusion.value.trim()); newExclusion.value = ''; } };

const newTool = ref('');
const addTool = () => { if (newTool.value.trim()) { form.capability_tools.push(newTool.value.trim()); newTool.value = ''; } };

const newMaterial = ref('');
const addMaterial = () => { if (newMaterial.value.trim()) { form.materials_used.push(newMaterial.value.trim()); newMaterial.value = ''; } };

const newLayout = ref('');
const addLayout = () => { if (newLayout.value.trim()) { form.architecture_layout.push(newLayout.value.trim()); newLayout.value = ''; } };

const removeBullet = (targetArray, index) => {
    targetArray.splice(index, 1);
};

const newOpBullet = ref('');
const addOpBullet = () => {
    if (!newOpBullet.value.trim()) return;
    form.operations_bullets.push(newOpBullet.value.trim());
    newOpBullet.value = '';
};
const removeOpBullet = (index) => {
    form.operations_bullets.splice(index, 1);
};

const submit = () => {
    if (props.service) {
        form.transform(data => ({
            ...data,
            _method: 'PUT'
        })).post(route('admin.services.update', props.service.id), {
            forceFormData: true,
        });
    } else {
        form.post(route('admin.services.store'), {
            forceFormData: true,
        });
    }
};
</script>

<template>
    <AdminLayout>
        <Head :title="service ? 'Engineer Capability' : 'Propose New Capability'" />

        <ModuleHeader :title="service ? `Service: ${service.title}` : 'New Capability'">
            <template #subtitle>
                <Link :href="route('admin.services.index')" class="text-[10px] font-black text-zinc-400 hover:text-primary uppercase tracking-[0.3em] flex items-center gap-2 mt-2 transition-colors">
                    <span>←</span> Return to Capability Matrix
                </Link>
            </template>
        </ModuleHeader>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Core Data -->
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-6 shadow-xl rounded-2xl text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-primary border-b border-[#242424] pb-4">Structural Parameters</h3>

                    <!-- Image Integration Module -->
                    <div class="space-y-4 pb-6 border-b border-[#242424]">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Featured Identity Asset</label>
                        <div class="flex items-center gap-6">
                            <div class="w-32 h-32 bg-[#0D0D0D] border border-[#242424] flex items-center justify-center overflow-hidden rounded-xl group relative shadow-inner">
                                <img v-if="imagePreview || form.image_url || service?.featured_image" :src="imagePreview || form.image_url || service?.featured_image" class="w-full h-full object-cover">
                                <span v-else class="text-zinc-600 text-3xl font-black italic">?</span>
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-[8px] font-black text-white uppercase tracking-widest">Live Preview</span>
                                </div>
                            </div>
                            <div class="flex-1 space-y-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label class="block px-4 py-3 bg-[#0D0D0D] border border-[#242424] hover:border-primary text-zinc-300 hover:text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all cursor-pointer text-center rounded-xl">
                                        Upload Asset
                                        <input type="file" class="hidden" accept="image/*" @change="handleImageChange">
                                    </label>
                                    <input v-model="form.image_url" type="url" @input="form.featured_image = null" placeholder="Or provide asset URL..." class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-4 py-3 text-xs text-white focus:ring-0 rounded-xl">
                                </div>
                                <p class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest leading-relaxed">Visual documentation required for public capability matrix.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Service Label</label>
                            <input v-model="form.title" type="text" required class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm font-bold uppercase tracking-tight text-white transition-all focus:ring-0 rounded-xl">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">URL Slug</label>
                            <input v-model="form.slug" type="text" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-xs font-bold tracking-tight text-white transition-all focus:ring-0 placeholder-zinc-600 rounded-xl" placeholder="auto-generated">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Short Overview</label>
                        <textarea v-model="form.short_description" rows="3" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm text-zinc-300 transition-all focus:ring-0 rounded-xl"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Full Operational Description</label>
                        <textarea v-model="form.description" rows="6" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm leading-relaxed text-zinc-300 transition-all focus:ring-0 rounded-xl"></textarea>
                    </div>
                </div>

                <!-- Capability Scope Section -->
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-6 shadow-xl rounded-2xl text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-primary border-b border-[#242424] pb-4">Capability Scope & Toolset</h3>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Functional Scope Description</label>
                        <textarea v-model="form.capability_scope_description" rows="3" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm text-zinc-300 transition-all focus:ring-0 rounded-xl" placeholder="Functional breadth of this capability..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Features -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400">Service Features</label>
                            <div class="space-y-2">
                                <div v-for="(item, i) in form.capability_features" :key="i" class="flex items-center gap-3 p-3 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                    <span class="flex-1 text-[10px] font-bold text-zinc-300">{{ item }}</span>
                                    <button type="button" @click="removeBullet(form.capability_features, i)" class="text-red-400 hover:text-red-600 text-xs">✕</button>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <input v-model="newFeature" @keydown.enter.prevent="addFeature" type="text" placeholder="Add feature..." class="flex-1 bg-[#0D0D0D] border border-[#242424] text-xs text-white rounded-xl p-2.5 focus:border-primary focus:ring-0">
                                <button type="button" @click="addFeature" class="bg-[#242424] hover:bg-primary px-4 text-white text-[10px] font-black uppercase rounded-xl transition-all">Add</button>
                            </div>
                        </div>

                        <!-- Deliverables -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400">Included Deliverables</label>
                            <div class="space-y-2">
                                <div v-for="(item, i) in form.capability_deliverables" :key="i" class="flex items-center gap-3 p-3 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                    <span class="flex-1 text-[10px] font-bold text-zinc-300">{{ item }}</span>
                                    <button type="button" @click="removeBullet(form.capability_deliverables, i)" class="text-red-400 hover:text-red-600 text-xs">✕</button>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <input v-model="newDeliverable" @keydown.enter.prevent="addDeliverable" type="text" placeholder="Add deliverable..." class="flex-1 bg-[#0D0D0D] border border-[#242424] text-xs text-white rounded-xl p-2.5 focus:border-primary focus:ring-0">
                                <button type="button" @click="addDeliverable" class="bg-[#242424] hover:bg-primary px-4 text-white text-[10px] font-black uppercase rounded-xl transition-all">Add</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tools -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400">Tools / Technologies</label>
                            <div class="space-y-2">
                                <div v-for="(item, i) in form.capability_tools" :key="i" class="flex items-center gap-3 p-3 bg-[#0D0D0D] border border-[#242424] rounded-xl">
                                    <span class="flex-1 text-[10px] font-bold text-zinc-300">{{ item }}</span>
                                    <button type="button" @click="removeBullet(form.capability_tools, i)" class="text-red-400 hover:text-red-600 text-xs">✕</button>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <input v-model="newTool" @keydown.enter.prevent="addTool" type="text" placeholder="Add tool..." class="flex-1 bg-[#0D0D0D] border border-[#242424] text-xs text-white rounded-xl p-2.5 focus:border-primary focus:ring-0">
                                <button type="button" @click="addTool" class="bg-[#242424] hover:bg-primary px-4 text-white text-[10px] font-black uppercase rounded-xl transition-all">Add</button>
                            </div>
                        </div>

                        <!-- Structural Type -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400">Structural Segment</label>
                            <input v-model="form.structural_type" type="text" placeholder="e.g. Corporate Infrastructure" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-4 py-3 text-xs text-white rounded-xl focus:ring-0 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Operations Module -->
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-6 shadow-xl rounded-2xl text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-primary border-b border-[#242424] pb-4">Operations & Governance</h3>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Operations Description</label>
                        <textarea v-model="form.operations_description" rows="3" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-5 py-3.5 text-sm text-zinc-300 transition-all focus:ring-0 rounded-xl" placeholder="Describe the operations scope..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Operations Timeline</label>
                            <input v-model="form.operations_timeline" type="text" placeholder="e.g. 12-24 weeks" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-4 py-3 text-sm text-white transition-all focus:ring-0 rounded-xl">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 block">Assigned Squad</label>
                            <input v-model="form.operations_team" type="text" placeholder="e.g. Principal Engineering Unit" class="w-full bg-[#0D0D0D] border border-[#242424] focus:border-primary px-4 py-3 text-sm text-white transition-all focus:ring-0 rounded-xl">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Controls -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-[#171717] border border-[#242424] p-8 space-y-8 shadow-xl rounded-2xl sticky top-28 text-white">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-zinc-400 border-b border-[#242424] pb-4">Operational Logic</h3>

                    <div class="space-y-3">
                        <label class="flex items-center gap-4 p-4 bg-[#0D0D0D] border border-[#242424] cursor-pointer hover:border-primary transition-all rounded-xl">
                            <input type="checkbox" v-model="form.is_public" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0 rounded">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-300">Internal Public</span>
                                <span class="text-[8px] text-zinc-500 font-bold uppercase">System Access</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 bg-[#0D0D0D] border border-[#242424] cursor-pointer hover:border-primary transition-all rounded-xl">
                            <input type="checkbox" v-model="form.is_public_visible" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0 rounded">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary">Web Visibility</span>
                                <span class="text-[8px] text-zinc-500 font-bold uppercase">Live on Capabilities Matrix</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 bg-[#0D0D0D] border border-[#242424] cursor-pointer hover:border-primary transition-all rounded-xl">
                            <input type="checkbox" v-model="form.is_featured" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0 rounded">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-300">Featured Offering</span>
                        </label>
                    </div>

                    <div class="space-y-3 border-t border-[#242424] pt-4">
                        <label v-for="status in ['draft', 'published']" :key="status"
                            class="flex items-center gap-4 p-3.5 bg-[#0D0D0D] border border-[#242424] cursor-pointer hover:border-[#383838] transition-all rounded-xl">
                            <input type="radio" v-model="form.status" :value="status" class="w-4 h-4 bg-[#171717] border-[#242424] text-primary focus:ring-0">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-300">{{ status }}</span>
                        </label>
                    </div>

                    <button type="submit" :disabled="form.processing" class="w-full py-4 bg-primary hover:bg-[#F97316] text-[#0D0D0D] font-display font-bold uppercase tracking-wider text-xs rounded-xl shadow-lg shadow-primary/20 transition-all disabled:opacity-50">
                        {{ form.processing ? 'Saving...' : (service ? 'Update Capability' : 'Commit Capability') }}
                    </button>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
