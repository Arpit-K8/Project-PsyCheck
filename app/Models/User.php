<?php

namespace App\Models;

use App\Mail\ResetPasswordMail;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'target_score',
        'streak_days',
        'consistency_rate',
        'emergency_contact_name',
        'emergency_contact_phone',
        'trusted_email',
        'alert_on_critical',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'alert_on_critical' => 'boolean',
        ];
    }

    public function sendPasswordResetNotification($token): void
    {
        Mail::to($this->email)->send(new ResetPasswordMail($this->email, $token));
    }

    /**
     * Recalculates streak_days and consistency_rate based on assessment history.
     */
    public function updateWellnessStats(): void
    {
        $results = AssessmentResult::where('user_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($results->isEmpty()) {
            $this->streak_days = 0;
            $this->consistency_rate = 0;
            $this->save();
            return;
        }

        // 1. Calculate streak_days based on consecutive assessment days
        $dates = $results->map(function ($r) {
            return $r->created_at->toDateString();
        })->unique()->flip();

        $streak = 0;
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        $currentDate = now();
        if ($dates->has($today)) {
            $checkDate = $today;
        } elseif ($dates->has($yesterday)) {
            $checkDate = $yesterday;
            $currentDate = now()->subDay();
        } else {
            $checkDate = null;
        }

        if ($checkDate !== null) {
            while (true) {
                $dateString = $currentDate->toDateString();
                if ($dates->has($dateString)) {
                    $streak++;
                    $currentDate->subDay();
                } else {
                    break;
                }
            }
        }

        // 2. Calculate consistency_rate (active days in the last 30 days)
        $activeDaysLast30 = 0;
        for ($i = 0; $i < 30; $i++) {
            $dateString = now()->subDays($i)->toDateString();
            if ($dates->has($dateString)) {
                $activeDaysLast30++;
            }
        }
        $consistencyRate = (int) round(($activeDaysLast30 / 30) * 100);

        $this->streak_days = $streak;
        $this->consistency_rate = $consistencyRate;
        $this->save();
    }
}
