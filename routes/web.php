<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');// folderName.fileName
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/assessment/start', function (\Illuminate\Http\Request $request) {
    $track = $request->input('track', 'mind');
    if (!in_array($track, ['body', 'mind', 'analysis'])) {
        $track = 'mind';
    }
    return view("assessment.{$track}.index", compact('track'));
})->middleware(['auth', 'verified'])->name('assessment.start');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/assessment/{track}/exam', [\App\Http\Controllers\AssessmentController::class, 'showExam'])->name('assessment.exam');
    Route::post('/assessment/{track}/exam', [\App\Http\Controllers\AssessmentController::class, 'submitExam'])->name('assessment.exam.submit');
    Route::post('/assessment/ai-analysis', [\App\Http\Controllers\AssessmentController::class, 'generateAiAnalysis'])->name('assessment.ai-analysis');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
