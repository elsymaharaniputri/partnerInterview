<?php

namespace App\Http\Controllers;

use App\Services\GraniteService;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    protected $granite;

    public function __construct(GraniteService $granite)
    {
        $this->granite = $granite;
    }

    public function generateQuestions(Request $request)
    {
        $request->validate([
            'position' => 'required',
            'industry' => 'required',
        ]);

        return $this->granite->generateInterviewQuestions($request->position, $request->industry);
    }
    public function analyzeAnswer(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        return $this->granite->analyzeAnswer($request->question, $request->answer);
    }
}
