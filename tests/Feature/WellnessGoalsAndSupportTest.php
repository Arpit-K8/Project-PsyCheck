<?php

use App\Models\User;
use App\Models\AssessmentResult;
use App\Mail\CriticalScoreAlertMail;
use Illuminate\Support\Facades\Mail;

test('user can update wellness goals and support circle details', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'target_score' => 85,
            'emergency_contact_name' => 'Jane Doe',
            'emergency_contact_phone' => '+15551234567',
            'trusted_email' => 'buddy@example.com',
            'alert_on_critical' => true,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertEquals(85, $user->target_score);
    $this->assertEquals('Jane Doe', $user->emergency_contact_name);
    $this->assertEquals('+15551234567', $user->emergency_contact_phone);
    $this->assertEquals('buddy@example.com', $user->trusted_email);
    $this->assertTrue((bool)$user->alert_on_critical);
});

test('submitting assessment updates streak and consistency rate', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/assessment/mind/exam', [
            'answers' => [
                1 => 3,
                2 => 3,
            ]
        ]);

    $response->assertRedirect();

    $user->refresh();

    // Streak should be 1 since we took an assessment today
    $this->assertEquals(1, $user->streak_days);
    // Consistency should be round((1 / 30) * 100) = 3%
    $this->assertEquals(3, $user->consistency_rate);
});

test('critical score triggers email to trusted contact', function () {
    Mail::fake();

    $user = User::factory()->create([
        'trusted_email' => 'buddy@example.com',
        'alert_on_critical' => true,
    ]);

    // Submitting a low percentage score: e.g. raw 0 health (meaning totalScore 0 out of max 6 = 0% health percentage)
    // 0% is < 50%, which is critical.
    $response = $this->actingAs($user)
        ->post('/assessment/mind/exam', [
            'answers' => [
                1 => 0,
                2 => 0,
            ]
        ]);

    $response->assertRedirect();

    Mail::assertQueued(CriticalScoreAlertMail::class, function ($mail) use ($user) {
        return $mail->hasTo('buddy@example.com') &&
               $mail->user->id === $user->id &&
               $mail->score === 0;
    });
});

test('user can update support circle settings independently without name and email validation errors', function () {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
        'target_score' => 75,
        'alert_on_critical' => true,
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'form_type' => 'support_circle',
            'target_score' => 90,
            'emergency_contact_name' => 'Support Contact',
            'emergency_contact_phone' => '+1999999999',
            'trusted_email' => 'new-support@example.com',
            'alert_on_critical' => false,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    // Verify support circle settings are updated
    $this->assertEquals(90, $user->target_score);
    $this->assertEquals('Support Contact', $user->emergency_contact_name);
    $this->assertEquals('+1999999999', $user->emergency_contact_phone);
    $this->assertEquals('new-support@example.com', $user->trusted_email);
    $this->assertFalse((bool)$user->alert_on_critical);

    // Verify original name and email are completely untouched
    $this->assertEquals('Original Name', $user->name);
    $this->assertEquals('original@example.com', $user->email);
});

test('user can update profile info independently without affecting support circle settings', function () {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
        'target_score' => 80,
        'emergency_contact_name' => 'Jane Doe',
        'trusted_email' => 'buddy@example.com',
        'alert_on_critical' => true,
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'form_type' => 'profile_info',
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    // Verify profile info is updated
    $this->assertEquals('New Name', $user->name);
    $this->assertEquals('new@example.com', $user->email);

    // Verify support circle settings are completely untouched and NOT overwritten or set to false
    $this->assertEquals(80, $user->target_score);
    $this->assertEquals('Jane Doe', $user->emergency_contact_name);
    $this->assertEquals('buddy@example.com', $user->trusted_email);
    $this->assertTrue((bool)$user->alert_on_critical);
});

