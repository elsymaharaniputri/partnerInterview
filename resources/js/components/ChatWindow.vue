<template>
    <div class="chat-container">
        <div class="chat-card">
            <button class="back-btn" @click="handleBack">
                <span>←</span>
            </button>

            <h2>Let’s Prepare Your<br />Interview Session</h2>
            <p>
                Hey there! To get started, please tell me the job title you’re aiming for
                and the type of company (e.g., Technology, Education, Retail). I’ll take it from there!
            </p>

            <form @submit.prevent="startSession" class="form-grid">
                <div class="form-field">
                    <label>Job Position</label>
                    <input v-model="position" placeholder="Type it here" />
                </div>
                <div class="form-field">
                    <label>Type of Company</label>
                    <input v-model="company" placeholder="Type it here" />
                </div>
                <button type="submit" class="send-btn ">Send</button>
            </form>
            <!-- 🟡 Tambahkan di sini -->
            <div v-if="loading" class="loading-text">Generating questions...</div>


            <!-- Chat messages muncul setelah submit -->
            <div v-if="messages.length" class="mt-4">
                <MessageBubble v-for="(msg, i) in messages" :key="i" :message="msg" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import MessageBubble from './MessageBubble.vue'
import { startSession as apiStartSession } from '../services/interviewApi'

const position = ref('')
const company = ref('')
const messages = ref([])
const loading = ref(false)

const handleBack = () => {
    if (typeof window !== 'undefined') {
        window.location.href = '/'
    }
}


async function startSession() {
    if (!position.value || !company.value) {
        alert('Please fill both fields.')
        return
    }

    try {
        loading.value = true

        // Kirim data ke backend (panggil API generate-questions)
        const res = await apiStartSession(position.value, company.value)

        if (res.status === 'success' && res.questions) {
            // tampilkan pesan pembuka
            messages.value.push({
                role: 'ai',
                text: `Alright! Let’s prepare you for your interview at ${company.value} for the ${position.value} position.`,
                time: Date.now(),
            })

            // tampilkan pertanyaan hasil dari backend
            messages.value.push({
                role: 'ai',
                text: res.questions.join('\n\n'),
                time: Date.now(),
            })
        } else {
            messages.value.push({
                role: 'ai',
                text: 'Sorry, I couldn’t generate questions at the moment.',
                time: Date.now(),
            })
        }
    } catch (err) {
        console.error(err)
        messages.value.push({
            role: 'ai',
            text: 'There was an error connecting to the server.',
            time: Date.now(),
        })
    } finally {
        loading.value = false
    }
}
</script>


<style scoped>
/* === Background Container === */
.chat-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(120deg, #d3e2ff, #f2e3ff);
    padding: 20px;
}

/* === Main Card === */
.chat-card {
    background: #fff;
    border-radius: 25px;
    padding: 50px 40px;
    width: 100%;
    max-width: 520px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    position: relative;
    text-align: left;
}

/* === Back Button === */
.back-btn {
    position: absolute;
    top: 18px;
    left: 18px;
    background: linear-gradient(135deg, #a8b0ff, #7b61ff);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 8px rgba(123, 97, 255, 0.3);
}

.back-btn:hover {
    opacity: 0.9;
}

/* === Title and Paragraph === */
h2 {
    font-size: 24px;
    font-weight: 700;
    color: #111;
    margin-bottom: 10px;
    line-height: 1.3;
}

p {
    font-size: 14px;
    color: #555;
    margin-bottom: 30px;
    line-height: 1.5;
}

/* === Form Layout === */
.form-grid {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 16px;
}

.form-field {
    flex: 1;
    display: flex;
    flex-direction: column;
}

label {
    font-size: 13px;
    font-weight: 500;
    color: #333;
    margin-bottom: 6px;
}

input {
    border: 1px solid #ddd;
    border-radius: 25px;
    padding: 10px 16px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}

input:focus {
    border-color: #7b61ff;
}

/* === Send Button === */
.send-btn {
    background: linear-gradient(90deg, #78A0FF, #C339D9);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s;
    white-space: nowrap;
}

.send-btn:hover,
.send-btn:hover {
    transform: scale(1.05);
}

.send-btn:active,
.send-btn:active {
    transform: scale(0.95);
}

/* === Responsive Adjustments === */
@media (max-width: 600px) {
    .chat-card {
        padding: 30px 20px;
    }

    .form-grid {
        flex-direction: column;
        gap: 12px;
    }

    .send-btn {
        width: 100%;
        text-align: center;
    }
}

.loading-text {
    text-align: center;
    color: #666;
    margin-top: 10px;
    font-style: italic;
    animation: blink 1.2s infinite;
}

/* Opsional: efek berkedip halus */
@keyframes blink {

    0%,
    100% {
        opacity: 0.6;
    }

    50% {
        opacity: 1;
    }
}
</style>
