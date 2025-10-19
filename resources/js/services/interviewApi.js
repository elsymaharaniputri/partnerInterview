// src/services/interviewApi.js
import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE || 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer 4|NRNTw0JUAg0BFt0pVsgJaq0bBTu8WvvhiGN0MpEa05747cef', // token dari Postman
  },
});



// helper untuk set token (dipanggil setelah login)
export function setAuthToken(token) {
  api.defaults.headers.common['Authorization'] = token ? `Bearer ${token}` : undefined;
}

export async function startSession(position, industry) {
  // call backend to create session & generate questions
  const res = await api.post('/generate-questions', { position, industry });
  return res.data;
}

export async function analyzeAnswer(sessionId, question, answer) {
  // call backend analyze
  const res = await api.post(`/analyze-answer`, { question, answer });
  return res.data;
}

export default api;
