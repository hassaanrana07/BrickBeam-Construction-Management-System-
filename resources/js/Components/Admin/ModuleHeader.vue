<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: String,
    actionText: String,
    actionRoute: String,
    search: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:search', 'search']);
</script>

<template>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 border-b border-[#242424] pb-6 transition-colors">
        <div>
            <h1 class="text-2xl sm:text-3xl font-display font-extrabold uppercase tracking-tight text-white mb-1.5">{{ title }}</h1>
            <slot name="subtitle"></slot>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <div v-if="$attrs.onSearch || $attrs['onUpdate:search']" class="relative group">
                <input 
                    :value="search"
                    @input="$emit('update:search', $event.target.value)"
                    type="text" 
                    placeholder="SEARCH MATRIX..." 
                    class="w-full sm:w-64 bg-[#171717] border border-[#242424] text-white text-xs font-mono uppercase tracking-wider px-4 py-2.5 pl-10 focus:border-[#E05A1B] focus:ring-0 transition-all placeholder:text-[#525252] rounded-xl group-hover:border-[#525252]"
                >
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#525252] group-focus-within:text-[#E05A1B] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <slot name="actions">
                <div v-if="actionRoute">
                    <Link :href="actionRoute" class="px-6 py-2.5 bg-[#E05A1B] hover:bg-[#F97316] text-[#0D0D0D] text-xs font-display font-bold uppercase tracking-wider transition-all shadow-lg shadow-[#E05A1B]/20 active:scale-95 flex items-center justify-center gap-2 whitespace-nowrap rounded-xl">
                        <span class="text-base font-bold">+</span> {{ actionText }}
                    </Link>
                </div>
            </slot>
        </div>
    </div>
</template>
