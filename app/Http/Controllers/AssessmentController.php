<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AssessmentController extends Controller
{
    public function showExam(Request $request, $track)
    {
        if (!in_array($track, ['body', 'mind', 'analysis'])) {
            return redirect()->route('dashboard');
        }

        $moduleFilter = $request->input('module');

        $query = \App\Models\AssessmentQuestion::where('module_name', $track);

        if ($moduleFilter) {
            $query->where('module', $moduleFilter);
        }

        // Fetch questions and keep module order stable.
        $questions = $query->orderBy('module')
            ->orderBy('id')
            ->get();

        return view('assessment.exam', compact('track', 'questions'));
    }

    public function submitExam(Request $request, $track)
    {
        $answers = $request->input('answers', []);
        
        // Higher raw scores mean more symptoms, but the stored score remains a health percentage.
        $totalScore = 0;
        $maxPossibleScore = count($answers) * 3;

        foreach ($answers as $qId => $selectedScore) {
            $totalScore += (int) $selectedScore;
        }

        $percentage = $maxPossibleScore > 0 ? round(($totalScore / $maxPossibleScore) * 100) : 0;

        // Determine mood/vitality and stress/tension based on the health percentage.
        if ($track === 'body') {
            if ($percentage >= 90) {
                $mood = 'Excellent';
                $stress = 'Very Low';
                $remarks = 'Exceptional physical vitality and somatic regulation. Your body is thriving! Keep nurturing the healthy physical habits that are currently working for you.';
            } elseif ($percentage >= 75) {
                $mood = 'Good';
                $stress = 'Low';
                $remarks = 'Your physical health is in a good place. You are managing physical stress and recovery well. Maintain your routine, but remember to rest adequately.';
            } elseif ($percentage >= 50) {
                $mood = 'Fair';
                $stress = 'Moderate';
                $remarks = 'You are experiencing a moderate amount of physical tension or fatigue. It is a good time to slow down, practice gentle recovery, and prioritize your physical well-being before burnout sets in.';
            } elseif ($percentage >= 30) {
                $mood = 'Tired';
                $stress = 'High';
                $remarks = 'Your responses indicate high physical stress levels and somatic exhaustion. Please consider stepping back from demanding tasks, getting plenty of sleep, and resting your body.';
            } else {
                $mood = 'Exhausted';
                $stress = 'Severe';
                $remarks = 'You are showing signs of severe physical exhaustion and autonomic dysregulation. It is highly recommended to reach out to a healthcare professional and prioritize immediate physical rest.';
            }
        } else {
            if ($percentage >= 90) {
                $mood = 'Excellent';
                $stress = 'Very Low';
                $remarks = 'Exceptional emotional balance and cognitive clarity. You are thriving! Keep nurturing the healthy habits that are currently working for you.';
            } elseif ($percentage >= 75) {
                $mood = 'Good';
                $stress = 'Low';
                $remarks = 'Your mental health is in a good place. You are handling daily pressures well. Maintain your routine, but do not forget to take short breaks when needed.';
            } elseif ($percentage >= 50) {
                $mood = 'Fair';
                $stress = 'Moderate';
                $remarks = 'You are experiencing a moderate amount of stress or cognitive fatigue. It is a good time to slow down, practice mindful self-care, and prioritize your well-being before burnout sets in.';
            } elseif ($percentage >= 30) {
                $mood = 'Tired';
                $stress = 'High';
                $remarks = 'Your responses indicate high stress levels and emotional exhaustion. Please consider stepping back from demanding tasks, getting plenty of rest, and seeking support if needed.';
            } else {
                $mood = 'Overwhelmed';
                $stress = 'Severe';
                $remarks = 'You are showing signs of severe stress and burnout. It is highly recommended to reach out for professional support, talk to a loved one, and prioritize your immediate mental health.';
            }
        }

        $titlePrefix = $request->input('module') ?: ucfirst($track) . ' Assessment';
        
        // Store result in DB
        $result = \App\Models\AssessmentResult::create([
            'user_id' => auth()->id(),
            'module_name' => $track,
            'title' => $titlePrefix . ' Check-in',
            'score' => $percentage,
            'mood' => $mood,
            'stress' => $stress,
            'remarks' => $remarks,
            'answers' => $answers,
        ]);

        return redirect()->route('assessment.start', ['track' => $track])
            ->with('success', 'Assessment completed successfully.');
    }

    public function generateAiAnalysis(Request $request)
    {
        $userId = auth()->id();
        $cacheKey = 'ai_credits_' . $userId . '_' . date('Y-m-d');
        $creditsUsed = Cache::get($cacheKey, 0);

        if ($creditsUsed >= 2) {
            return response()->json([
                'error' => 'Daily limit reached. You can only generate 2 AI analyses per day. It will revive at midnight.'
            ], 429);
        }

        $latestMind = \App\Models\AssessmentResult::where('user_id', $userId)
            ->where('module_name', 'mind')
            ->orderBy('created_at', 'desc')
            ->first();

        $latestBody = \App\Models\AssessmentResult::where('user_id', $userId)
            ->where('module_name', 'body')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestMind || !$latestBody) {
            return response()->json(['error' => 'Incomplete data. Both Mind and Body assessments are required.'], 400);
        }

        // Construct prompt
        $prompt = "You are a professional holistic health expert. Given the following user data, provide a structured, formatted markdown analysis of their psycho-somatic health along with 3 actionable steps to improve.\n\n";
        $prompt .= "Mind Score: {$latestMind->score}% (Mood: {$latestMind->mood}, Stress: {$latestMind->stress})\n";
        $prompt .= "Body Score: {$latestBody->score}% (Vitality: {$latestBody->mood}, Tension: {$latestBody->stress})\n\n";
        $prompt .= "FORMATTING INSTRUCTIONS: You MUST format your response into clear, distinct sections using Markdown H3 (###) headers. Use unordered bullet points (-) for all actionable steps. Separate every paragraph with a blank line. Use **bold** text to highlight key metrics and terms. Do not return a dense block of text. Keep it premium, structural, and easy to read.";

        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey) || $apiKey === 'your_api_key') {
            return response()->json(['error' => 'Gemini API Key is not configured properly on the server.'], 500);
        }

        try {
            $response = Http::withoutVerifying()->timeout(120)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiText = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Could not parse response from AI.';
                
                // Increment credits
                Cache::put($cacheKey, $creditsUsed + 1, now()->endOfDay());

                return response()->json([
                    'success' => true,
                    'content' => $aiText,
                    'credits_remaining' => 2 - ($creditsUsed + 1)
                ]);
            } else {
                $errorBody = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? 'Unknown API Error';
                return response()->json(['error' => "API Error ({$response->status()}): {$errorMessage}"], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while generating analysis: ' . $e->getMessage()], 500);
        }
    }
}
