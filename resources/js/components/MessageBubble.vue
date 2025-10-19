<template>
    <div :class="['bubble-row', isAI ? 'ai' : 'user']" :title="timestampText">
        <img v-if="isAI" class="avatar" :src="avatar" alt="AI" />
        <div :class="['bubble', variantClass]">
            <div v-if="message.icon" class="icon">{{ message.icon }}</div>
            <div class="content" v-html="formattedMessage"></div>
            <div class="meta">
                <small v-if="message.role === 'ai'">AI • {{ timeFormatted }}</small>
                <small v-else>Anda • {{ timeFormatted }}</small>
            </div>
        </div>
        <img v-if="!isAI" class="avatar user-avatar" src="" alt="You" />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import avatar from '../../assets/maskot.png';
const props = defineProps({
    message: { type: Object, required: true } // { role: 'ai'|'user'|'feedback', text, icon?, time }
});

const isAI = computed(() => props.message.role === 'ai');
const variantClass = computed(() => {
    if (props.message.role === 'feedback') return 'feedback';
    return isAI.value ? 'ai-bubble' : 'user-bubble';
});

const timeFormatted = new Date(props.message.time || Date.now()).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
const timestampText = new Date(props.message.time || Date.now()).toString();

const formattedMessage = computed(() => {
    // minimal: preserve newlines
    return (props.message.text || '').replace(/\n/g, '<br/>');
});
</script>

<style scoped>
.bubble-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin: 12px 0;
}

.bubble-row.ai {
    justify-content: flex-start;
}

.bubble-row.user {
    justify-content: flex-end;
}

.avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: #eee;
}

.bubble {
    max-width: 72%;
    padding: 12px 14px;
    border-radius: 14px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
    position: relative;
    font-size: 14px;
    line-height: 1.4;
}

/* AI & user colors */
.ai-bubble {
    background: #f1f5ff;
    color: #0b3b8a;
    border-top-left-radius: 4px;
}

.user-bubble {
    background: #dcf8c6;
    color: #072;
    border-top-right-radius: 4px;
}

/* feedback special */
.feedback {
    background: #a8b0ff;
    color: #7b61ff;
    border: 1px solid #a8b0ff;
    display: flex;
    gap: 8px;
    align-items: flex-start;
}

.icon {
    font-size: 18px;
    margin-right: 6px;
}

.content {
    white-space: pre-wrap;
    word-wrap: break-word;
}

/* meta time */
.meta {
    margin-top: 8px;
    opacity: 0.6;
    font-size: 11px;
    text-align: right;
}
</style>
