<template>
    <div class="timer-badge" v-if="visible">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24">
            <path fill="currentColor"
                d="M12 1a11 11 0 1 0 11 11A11 11 0 0 0 12 1Zm1 6h-2v6l5.2 3.12 1-1.64L13 12.25V7Z" />
        </svg>
        <span>{{ mm }}:{{ ss }}</span>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
const props = defineProps({
    seconds: { type: Number, default: 60 },
    active: { type: Boolean, default: false }
});
const visible = ref(false);
const remaining = ref(props.seconds);

let timer = null;

watch(() => props.active, (v) => {
    if (v) start();
    else stop();
});

function start() {
    visible.value = true;
    remaining.value = props.seconds;
    stop();
    timer = setInterval(() => {
        if (remaining.value > 0) remaining.value--;
        else stop();
    }, 1000);
}

function stop() {
    if (timer) { clearInterval(timer); timer = null; }
    if (!props.active) visible.value = false;
}

onBeforeUnmount(() => stop());

const mm = computed(() => String(Math.floor(remaining.value / 60)).padStart(2, '0'));
const ss = computed(() => String(remaining.value % 60).padStart(2, '0'));
</script>

<style scoped>
.timer-badge {
    display: inline-flex;
    gap: 6px;
    align-items: center;
    padding: 6px 8px;
    border-radius: 999px;
    background: rgba(0, 0, 0, 0.06);
    font-size: 12px;
    color: #111;
}

.timer-badge svg {
    opacity: 0.8;
}
</style>
