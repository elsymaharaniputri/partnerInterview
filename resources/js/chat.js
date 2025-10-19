import { createApp } from 'vue'
import ChatWindow from './components/ChatWindow.vue'

const app = createApp(ChatWindow)

app.component('ChatWindow', ChatWindow)
app.mount('#app')