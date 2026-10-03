<script setup>
import { ref, watch } from 'vue';
import draggable from 'vuedraggable';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['update:modelValue']);

const sections = ref([...props.modelValue]);

const sectionTypes = [
    { type: 'hero', label: 'Hero Banner', icon: 'M4 4h16v16H4V4zm2 2v12h12V6H6zm3 3h6v2H9V9z' },
    { type: 'credibility', label: 'Credibility Strip', icon: 'M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM9 17H7v-2h2v2zm0-4H7v-2h2v2zm0-4H7V7h2v2zm10 8H11v-2h8v2zm0-4H11v-2h8v2zm0-4H11V7h8v2z' },
    { type: 'services_overview', label: 'Services Grid', icon: 'M4 4h16v16H4V4zm2 2v12h12V6H6zm3 3h6v2H9V9zm0 4h6v2H9v-2z' },
    { type: 'featured_projects', label: 'Project Showcase', icon: 'M19 19H5V5h7V3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2v-7h-2v7z M14 3v2h3.586l-9.293 9.293 1.414 1.414L19 6.414V10h2V3h-7z' },
    { type: 'why_choose_us', label: 'Value Propositions', icon: 'M20 18c0 1.103-.897 2-2 2H6c-1.103 0-2-.897-2-2V7c0-1.103.897-2 2-2h12c1.103 0 2 .897 2 2v11zM6 7v11h12V7H6zm3 3h6v2H9v-2zm0 4h6v2H9v-4z' },
    { type: 'cta', label: 'Call to Action', icon: 'M13 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1' },
    { type: 'testimonials', label: 'Client Feedback', icon: 'M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zM8.5 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm7 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM12 18c-2.28 0-4.22-1.46-4.9-3.5h9.8c-.68 2.04-2.62 3.5-4.9 3.5z' },
    { type: 'story', label: 'Company Story', icon: 'M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm0 16H5V5h14v14zM7 7h10v2H7V7zm0 4h10v2H7v-2zm0 4h7v2H7v-2z' },
    { type: 'about', label: 'About BrickBeam (3D)', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' },
    { type: 'mission_values', label: 'Mission & Values', icon: 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5' },
    { type: 'pillars', label: 'Architectural Pillars', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
    { type: 'project_models', label: 'Project Models', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' },
    { type: 'values', label: 'Operational Values', icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M3 9a9 9 0 0018 0V9a9 9 0 00-18 0zm6 12l-2-2 2-2m6 0l2 2-2 2' },
    { type: 'legal_content', label: 'Legal & Policy Section', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
    { type: 'contact_form', label: 'Contact Terminal', icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
    { type: 'contact_info', label: 'HQ & Locations', icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z' },
    { type: 'faq_list', label: 'FAQ Accordion', icon: 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' },
    { type: 'footer_branding', label: 'Footer Narrative', icon: 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z' },
    { type: 'footer_links', label: 'Footer Links Grid', icon: 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101' },
    { type: 'leadership', label: 'Leadership Grid', icon: 'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z' },
    { type: 'timeline', label: 'Growth Timeline', icon: 'M21 15.75c0-.414-.336-.75-.75-.75h-1.5v-1.5c0-.414-.336-.75-.75-.75h-1.5v-1.5c0-.414-.336-.75-.75-.75h-1.5v-1.5c0-.414-.336-.75-.75-.75h-1.5v-1.5c0-.414-.336-.75-.75-.75h-1.5v-1.5c0-.414-.336-.75-.75-.75h-1.5V3.75c0-.414-.336-.75-.75-.75s-.75.336-.75.75v10.5H3.75c-.414 0-.75.336-.75.75s.336.75.75.75h10.5v1.5h-1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.5v1.5h-1.5c-.414 0-.75.336-.75.75s.336.75.75.75H15v1.5h-1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.5v1.5h-1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.5v1.5h-1.5c-.414 0-.75.336-.75.75s.336.75.75.75H20.25c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-1.5v-1.5h1.5c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-1.5v-1.5h1.5c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-1.5v-1.5h1.5c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-1.5v-1.5h1.5c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z' },
    { type: 'certifications', label: 'Certifications', icon: 'M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z' },
    { type: 'before_after', label: 'Before/After Slider', icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { type: 'safety', label: 'Safety Standards', icon: 'M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2zm0-6h2v4h-2z' },
    { type: 'service_list', label: 'Dynamic Service List', icon: 'M4 4h16boldv16H4V4zm2 2v12h12V6H6zm3 3h6v2H9V9zm0 4h6v2H9v-2z' },
    { type: 'project_list', label: 'Dynamic Project List', icon: 'M23 18V6a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2h18a2 2 0 002-2zM8.5 12.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z' },
    { type: 'blog_list', label: 'Dynamic Blog List', icon: 'M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H6V4h12v16zm-2-14H8v2h8V6zm-4 4H8v2h4v-2zm4 0h-2v2h2v-2zm-4 4H8v2h4v-2zm4 0h-2v2h2v-2z' },
    { type: 'pricing', label: 'Estimation/Pricing', icon: 'M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z' },
];

const addSection = (type) => {
    sections.value.push({
        id: Str_uid(),
        type,
        content: { 
            title: '', 
            subtitle: '', 
            description: '',
            button_text: '',
            button_link: '',
            image: '',
            image_url: '',
            features: []
        },
        settings: {
            background: 'default',
            padding: 'normal'
        }
    });
};

const removeSection = (index) => {
    if (confirm('Eradicate this structural node?')) {
        sections.value.splice(index, 1);
    }
};

const Str_uid = () => Math.random().toString(36).substring(2, 11).toUpperCase();

watch(sections, (newVal) => {
    emit('update:modelValue', newVal);
}, { deep: true });

const handleSectionImage = (e, index) => {
    const file = e.target.files[0];
    if (file) {
        sections.value[index].content.image = file;
    }
};

const previewFile = (file) => {
    if (!file) return '';
    return URL.createObjectURL(file);
};

const resolveImage = (path) => {
    if (!path) return null;
    if (path.startsWith('http')) return path;
    return path.startsWith('/') ? path : '/storage/' + path;
};

watch(() => props.modelValue, (newVal) => {
    if (JSON.stringify(newVal) !== JSON.stringify(sections.value)) {
        sections.value = [...newVal];
    }
}, { deep: true });
</script>

<template>
    <div class="space-y-8">
        <!-- Section Assembly -->
        <draggable 
            v-model="sections" 
            item-key="id"
            handle=".drag-handle"
            class="space-y-6"
            ghost-class="opacity-50"
        >
            <template #item="{ element, index }">
                <div class="bg-[#171717] border border-[#242424] group shadow-xl overflow-hidden rounded-2xl">
                    
                    <!-- Section Header/Controls -->
                    <div class="flex justify-between items-center px-6 sm:px-8 py-4 bg-[#121212] border-b border-[#242424]">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="drag-handle cursor-move w-8 h-8 bg-[#171717] flex items-center justify-center border border-[#242424] hover:border-[#E05A1B] transition-colors rounded-lg">
                                <svg class="w-4 h-4 text-[#737373] group-hover:text-[#E05A1B]" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10 9h4V7h-4v2zm0 4h4v-2h-4v2zm0 4h4v-2h-4v2zm-7-8h4V7H3v2zm0 4h4v-2H3v2zm0 4h4v-2H3v2z" />
                                </svg>
                            </div>
                            <div class="w-7 h-7 bg-[#E05A1B]/10 border border-[#E05A1B]/30 flex items-center justify-center rounded-lg">
                                <span class="text-[11px] font-mono font-bold text-[#E05A1B]">{{ index + 1 }}</span>
                            </div>
                            <span class="text-xs font-mono font-bold uppercase tracking-wider text-white">
                                {{ sectionTypes.find(t => t.type === element.type)?.label || 'GENERIC_NODE' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <button @click="removeSection(index)" class="w-8 h-8 flex items-center justify-center bg-red-950/30 text-red-400 hover:bg-red-600 hover:text-white transition-all rounded-lg" title="Remove Section">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Field Inputs -->
                    <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                        <div class="space-y-5">
                            <div>
                                <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Heading Factor</label>
                                <input v-model="element.content.title" type="text" class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] px-4 py-3 text-xs font-display font-bold uppercase tracking-tight text-white transition-all rounded-xl focus:ring-0">
                            </div>
                            <div>
                                <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Sub-Heading / Alt Logic</label>
                                <textarea v-model="element.content.subtitle" rows="2" class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] px-4 py-3 text-xs font-mono text-white transition-all rounded-xl focus:ring-0"></textarea>
                            </div>
                            <div>
                                <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Narrative / Description</label>
                                <textarea v-model="element.content.description" rows="4" class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] px-4 py-3 text-xs font-sans text-[#D4D4D4] leading-relaxed transition-all rounded-xl focus:ring-0"></textarea>
                            </div>
                        </div>
                        
                        <div class="space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Action Text</label>
                                    <input v-model="element.content.button_text" type="text" class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] px-4 py-3 text-xs font-display font-bold uppercase tracking-tight text-white transition-all rounded-xl focus:ring-0" placeholder="e.g. CONSULT">
                                </div>
                                <div>
                                    <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Action Vector (URL)</label>
                                    <input v-model="element.content.button_link" type="text" class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] px-4 py-3 text-xs font-mono text-white transition-all rounded-xl focus:ring-0" placeholder="/contact">
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-2 block">Visual Asset Integration</label>
                                <div class="flex items-center gap-4 p-4 bg-[#121212] border border-[#242424] rounded-xl">
                                    <div class="w-16 h-16 bg-[#171717] border border-[#242424] flex items-center justify-center overflow-hidden rounded-lg shadow-sm shrink-0">
                                        <img v-if="element.content.image" 
                                             :src="typeof element.content.image === 'string' ? resolveImage(element.content.image) : previewFile(element.content.image)" 
                                             class="w-full h-full object-cover">
                                        <span v-else class="text-[#525252] text-sm font-mono font-bold">NONE</span>
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <label class="block px-3 py-2 bg-[#171717] border border-[#242424] hover:border-[#E05A1B] text-[#A3A3A3] hover:text-white text-[10px] font-display font-bold uppercase tracking-wider transition-all cursor-pointer text-center rounded-lg shadow-sm">
                                            Select Asset File
                                            <input type="file" class="hidden" accept="image/*" @change="(e) => handleSectionImage(e, index)">
                                        </label>
                                        <p class="text-[9px] text-[#525252] font-mono text-center">JPG, PNG, WebP · Max 2MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-[#A3A3A3] mb-1 block">Direct Asset URL Vector</label>
                                <input v-model="element.content.image_url" type="text" 
                                    class="w-full bg-[#121212] border border-[#242424] focus:border-[#E05A1B] px-4 py-3 text-xs font-mono text-white transition-all rounded-xl focus:ring-0" 
                                    placeholder="https://images.unsplash.com/...">
                                <p class="text-[9px] text-[#525252] font-mono">Injected URL overrides local binary assets if provided.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section Footer/Metadata -->
                    <div class="bg-[#121212] px-6 sm:px-8 py-3 border-t border-[#242424] flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <span class="text-[9px] font-mono text-[#525252] uppercase">ID: {{ element.id || 'NODE' }}</span>
                            <span class="text-[9px] font-mono text-[#525252] uppercase">TYPE: {{ element.type.toUpperCase() }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E05A1B] animate-pulse"></span>
                            <span class="text-[9px] font-mono text-[#737373] uppercase tracking-wider">Node Synchronized</span>
                        </div>
                    </div>
                </div>
            </template>
        </draggable>

        <!-- Add Section Interface -->
        <div class="border-2 border-dashed border-[#242424] bg-[#141414]/60 p-10 sm:p-12 text-center rounded-2xl relative overflow-hidden group">
            <p class="text-xs font-mono font-bold uppercase tracking-[0.3em] text-[#A3A3A3] mb-8 relative z-10">Inject Structural Component to Matrix</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 relative z-10">
                <button v-for="type in sectionTypes" :key="type.type" 
                    @click="addSection(type.type)"
                    class="group/btn flex flex-col items-center gap-3 p-4 bg-[#171717] border border-[#242424] hover:border-[#E05A1B] hover:bg-[#202020] transition-all duration-200 rounded-xl">
                    <svg class="w-5 h-5 text-[#737373] group-hover/btn:text-[#E05A1B] transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path :d="type.icon" />
                    </svg>
                    <span class="text-[10px] font-display font-bold uppercase tracking-wider text-[#A3A3A3] group-hover/btn:text-white transition-colors">{{ type.label }}</span>
                </button>
            </div>
        </div>
        
        <div v-if="sections.length === 0" class="py-16 text-center">
            <p class="text-xs font-mono uppercase tracking-widest text-[#525252]">No structural components assembled for this node.</p>
        </div>
    </div>
</template>

<style scoped>
input:focus, textarea:focus {
    outline: none;
    box-shadow: 0 0 15px rgba(224, 90, 27, 0.15);
}
</style>
