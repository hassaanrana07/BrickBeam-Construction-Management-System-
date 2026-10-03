<script setup>
import { ref, onMounted } from 'vue';

const stats = ref([
    { label: 'Projects Managed', target: 150, suffix: '+', current: 0, code: 'METRIC-01' },
    { label: 'On-Time Schedule Delivery', target: 98, suffix: '%', current: 0, code: 'METRIC-02' },
    { label: 'Specialty Subcontractor Trades', target: 45, suffix: '+', current: 0, code: 'METRIC-03' },
    { label: 'Capital Value Supervised', target: 250, prefix: 'PKR ', suffix: 'M+', current: 0, code: 'METRIC-04' }
]);

const sectionRef = ref(null);
let countersStarted = false;

const startCounters = () => {
    if (countersStarted) return;
    countersStarted = true;

    stats.value.forEach(stat => {
        const duration = 1600;
        const startTime = performance.now();
        const update = (now) => {
            const progress = Math.min((now - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            stat.current = Math.floor(ease * stat.target);
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                stat.current = stat.target;
            }
        };
        requestAnimationFrame(update);
    });
};

onMounted(() => {
    if (sectionRef.value) {
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                startCounters();
                observer.disconnect();
            }
        }, { threshold: 0.2 });
        observer.observe(sectionRef.value);
    } else {
        startCounters();
    }
});
</script>

<template>
    <section ref="sectionRef" class="py-14 bg-[#111111] border-y border-[#242424] relative z-20 overflow-hidden">
        <!-- Subtle Grid -->
        <div class="absolute inset-0 cad-dots opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                <div 
                    v-for="(stat, idx) in stats" 
                    :key="idx" 
                    class="p-6 bg-[#171717] border border-[#242424] hover:border-[#E05A1B]/60 rounded-xl relative overflow-hidden group transition-all duration-300 corner-crosshair shadow-lg"
                >
                    <!-- Technical Code Header -->
                    <div class="flex items-center justify-between mb-3 text-[9px] font-mono text-[#525252] group-hover:text-[#A3A3A3] transition-colors">
                        <span>{{ stat.code }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-[#242424] group-hover:bg-[#E05A1B] transition-colors"></span>
                    </div>

                    <!-- Number Counter -->
                    <div class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-2 flex items-baseline">
                        <span>{{ stat.prefix || '' }}</span>
                        <span class="text-white group-hover:text-[#E05A1B] transition-colors">{{ stat.current }}</span>
                        <span class="text-[#E05A1B] text-2xl sm:text-3xl ml-0.5">{{ stat.suffix }}</span>
                    </div>

                    <!-- Metric Label -->
                    <p class="font-display text-xs font-semibold uppercase tracking-wider text-[#A3A3A3]">
                        {{ stat.label }}
                    </p>

                    <!-- Bottom Accent Track -->
                    <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-[#E05A1B] group-hover:w-full transition-all duration-500"></div>
                </div>
            </div>
        </div>
    </section>
</template>
