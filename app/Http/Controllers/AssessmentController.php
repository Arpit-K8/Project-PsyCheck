<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        // Determine mood and stress based on the health percentage.
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
}
