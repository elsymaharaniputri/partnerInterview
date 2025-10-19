<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GraniteService
{
    protected $apiUrl = 'https://api.replicate.com/v1/predictions';
    protected $version = 'a325a0cacfb0aa9226e6bad1abe5385f1073f4c7f8c36e52ed040e5409e6c034'; 

    public function generateInterviewQuestions($position, $industry)
    {
        $prompt = "Buat 3 pertanyaan wawancara spesifik untuk posisi {$position} di industri {$industry}.";

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . env('REPLICATE_API_TOKEN'),
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'version' => $this->version,
            'input' => [
                'prompt' => $prompt,
            ],
        ]);

        $data = $response->json();

        // Tunggu hasil prediksi selesai
        if (isset($data['urls']['get'])) {
            sleep(3); // beri waktu model memproses
            $result = Http::withHeaders([
                'Authorization' => 'Token ' . env('REPLICATE_API_TOKEN'),
            ])->get($data['urls']['get'])->json();

            return [
                'status' => 'success',
                'questions' => $result['output'] ?? ['(tidak ada output dari model)'],
            ];
        }

        return [
            'status' => 'error',
            'message' => $data['error'] ?? 'Gagal memproses permintaan.',
        ];
    }

    public function analyzeAnswer($question, $answer)
    {
        $prompt = "Pertanyaan: {$question}\nJawaban: {$answer}\nAnalisis: jelaskan kejelasan, kesesuaian, dan beri saran perbaikan.";

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . env('REPLICATE_API_TOKEN'),
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'version' => $this->version,
            'input' => [
                'prompt' => $prompt,
            ],
        ]);

        $data = $response->json();

        if (isset($data['urls']['get'])) {
            sleep(3);
            $result = Http::withHeaders([
                'Authorization' => 'Token ' . env('REPLICATE_API_TOKEN'),
            ])->get($data['urls']['get'])->json();

            return [
                'status' => 'success',
                'feedback' => $result['output'] ?? ['(tidak ada output dari model)'],
            ];
        }

        return [
            'status' => 'error',
            'message' => $data['error'] ?? 'Gagal memproses jawaban.',
        ];
    }
}
