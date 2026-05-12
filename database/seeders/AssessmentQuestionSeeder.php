<?php

namespace Database\Seeders;

use App\Models\AssessmentQuestion;
use Illuminate\Database\Seeder;

class AssessmentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssessmentQuestion::where('module_name', 'mind')->delete();

        $options = [
            ['text' => 'Not at all', 'score' => 3, 'type' => 'Ideal'],
            ['text' => 'Several days', 'score' => 2, 'type' => 'Neutral'],
            ['text' => 'More than half the days', 'score' => 1, 'type' => 'Warning'],
            ['text' => 'Nearly every day', 'score' => 0, 'type' => 'Non-Ideal'],
        ];

        $questionBank = [
            [
                'id' => 1,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt "wound up" or unable to sit still?',
            ],
            [
                'id' => 2,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you experienced shallow breathing or chest tightness under pressure?',
            ],
            [
                'id' => 3,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you were losing your temper over small inconveniences?',
            ],
            [
                'id' => 4,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you suffered from digestive issues or "butterflies" due to worry?',
            ],
            [
                'id' => 5,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt your heart racing without physical exertion?',
            ],
            [
                'id' => 6,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you have too many responsibilities and not enough time?',
            ],
            [
                'id' => 7,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you used caffeine or sugar just to get through a stressful afternoon?',
            ],
            [
                'id' => 8,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt physically exhausted even after a full night\'s sleep?',
            ],
            [
                'id' => 9,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you ground your teeth or clenched your jaw?',
            ],
            [
                'id' => 10,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt a "weight" on your shoulders or neck?',
            ],
            [
                'id' => 11,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you found it hard to switch off your "work brain" at home?',
            ],
            [
                'id' => 12,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt panicked by a notification or email?',
            ],
            [
                'id' => 13,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you are neglecting your personal life for work/study?',
            ],
            [
                'id' => 14,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that your "to-do" list is impossible to finish?',
            ],
            [
                'id' => 15,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt lightheaded or dizzy when thinking about your tasks?',
            ],
            [
                'id' => 16,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you avoided a task because the thought of it made you anxious?',
            ],
            [
                'id' => 17,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you are constantly "fighting fires" rather than planning?',
            ],
            [
                'id' => 18,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you lack a support system to help with your stress?',
            ],
            [
                'id' => 19,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you experienced cold hands or feet during high-pressure moments?',
            ],
            [
                'id' => 20,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that your environment (noise, clutter) is adding to your stress?',
            ],
            [
                'id' => 21,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt a lack of appetite due to mental pressure?',
            ],
            [
                'id' => 22,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you are operating on "autopilot"?',
            ],
            [
                'id' => 23,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you are "faking" being okay?',
            ],
            [
                'id' => 24,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that your hobbies feel like "chores"?',
            ],
            [
                'id' => 25,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt a sudden urge to cry without a clear reason?',
            ],
            [
                'id' => 26,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you are pushing yourself too hard?',
            ],
            [
                'id' => 27,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt a sense of urgency about things that aren\'t urgent?',
            ],
            [
                'id' => 28,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you are unable to enjoy your "free time"?',
            ],
            [
                'id' => 29,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that your sleep quality is poor?',
            ],
            [
                'id' => 30,
                'module' => 'Stress Pattern',
                'question' => 'How frequently have you felt that you are physically "on the verge" of getting sick?',
            ],
            [
                'id' => 31,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you struggled to focus on a single task for more than 10 minutes?',
            ],
            [
                'id' => 32,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you forgotten what you were about to say mid-sentence?',
            ],
            [
                'id' => 33,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you had to re-read the same paragraph multiple times to understand it?',
            ],
            [
                'id' => 34,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you misplaced everyday items like your phone or keys?',
            ],
            [
                'id' => 35,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your thoughts are "muddled" or "foggy"?',
            ],
            [
                'id' => 36,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you struggled to solve problems that used to be easy for you?',
            ],
            [
                'id' => 37,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you missed an appointment or a deadline?',
            ],
            [
                'id' => 38,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you found yourself staring at a screen without actually working?',
            ],
            [
                'id' => 39,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your brain is "full" and cannot take in more info?',
            ],
            [
                'id' => 40,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you struggled to follow the plot of a movie or book?',
            ],
            [
                'id' => 41,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you made careless mistakes in your work?',
            ],
            [
                'id' => 42,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your vocabulary is "slipping" (struggling for words)?',
            ],
            [
                'id' => 43,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt mentally "sluggish" in the mornings?',
            ],
            [
                'id' => 44,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you been easily distracted by background noise?',
            ],
            [
                'id' => 45,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you struggled to organize your day effectively?',
            ],
            [
                'id' => 46,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that you are losing your "creative spark"?',
            ],
            [
                'id' => 47,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you found it hard to learn a new skill or software?',
            ],
            [
                'id' => 48,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your reaction time is slower than usual?',
            ],
            [
                'id' => 49,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you forgotten to reply to important messages?',
            ],
            [
                'id' => 50,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that you are "zoning out" during meetings or classes?',
            ],
            [
                'id' => 51,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you struggled to keep track of multiple tasks at once?',
            ],
            [
                'id' => 52,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your decision-making is influenced by "mental fatigue"?',
            ],
            [
                'id' => 53,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you had trouble remembering names of people you just met?',
            ],
            [
                'id' => 54,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your "mental energy" runs out by noon?',
            ],
            [
                'id' => 55,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you struggled to visualize a concept or plan?',
            ],
            [
                'id' => 56,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you found yourself "doom-scrolling" instead of focusing?',
            ],
            [
                'id' => 57,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your mind is racing too fast to catch a single thought?',
            ],
            [
                'id' => 58,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you struggled with basic mental math?',
            ],
            [
                'id' => 59,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that your focus is fragmented?',
            ],
            [
                'id' => 60,
                'module' => 'Cognitive Function & Focus',
                'question' => 'How frequently have you felt that you need extra time to process simple instructions?',
            ],
            [
                'id' => 61,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt a lack of interest in social activities?',
            ],
            [
                'id' => 62,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt irritable toward people you care about?',
            ],
            [
                'id' => 63,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that your mood swings are beyond your control?',
            ],
            [
                'id' => 64,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt a sense of emptiness or "numbness"?',
            ],
            [
                'id' => 65,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are being judged by others?',
            ],
            [
                'id' => 66,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt a lack of confidence in your abilities?',
            ],
            [
                'id' => 67,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that your future looks bleak or uninteresting?',
            ],
            [
                'id' => 68,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt sensitive to changes in your routine?',
            ],
            [
                'id' => 69,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt "guilty" for resting?',
            ],
            [
                'id' => 70,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are a burden to others?',
            ],
            [
                'id' => 71,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that small setbacks feel like major disasters?',
            ],
            [
                'id' => 72,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt unable to find joy in your favorite foods?',
            ],
            [
                'id' => 73,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are "withdrawing" into yourself?',
            ],
            [
                'id' => 74,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you lack a sense of purpose?',
            ],
            [
                'id' => 75,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt overly self-critical?',
            ],
            [
                'id' => 76,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are "acting" happy rather than being happy?',
            ],
            [
                'id' => 77,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt a need for constant reassurance from others?',
            ],
            [
                'id' => 78,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt a sense of restlessness or "agitation"?',
            ],
            [
                'id' => 79,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that your emotions are "blocked"?',
            ],
            [
                'id' => 80,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are more emotional than usual?',
            ],
            [
                'id' => 81,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are avoiding eye contact with others?',
            ],
            [
                'id' => 82,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are easily hurt by feedback?',
            ],
            [
                'id' => 83,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are "stuck" in the same emotional loop?',
            ],
            [
                'id' => 84,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you have no one to talk to about your feelings?',
            ],
            [
                'id' => 85,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are losing your sense of humor?',
            ],
            [
                'id' => 86,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are constantly comparing yourself to others?',
            ],
            [
                'id' => 87,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt a lack of motivation to maintain your appearance?',
            ],
            [
                'id' => 88,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are dwelling on past mistakes?',
            ],
            [
                'id' => 89,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are "mentally fragile"?',
            ],
            [
                'id' => 90,
                'module' => 'Emotional Balance',
                'question' => 'How frequently have you felt that you are losing your connection to your surroundings?',
            ],
        ];

        $rows = [];
        foreach ($questionBank as $item) {
            $rows[] = [
                'module_name' => 'mind',
                'module' => $item['module'],
                'question_text' => $item['question'],
                'options' => json_encode($options),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        AssessmentQuestion::insert($rows);
    }
}
