<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('target_score')->default(75);
            $table->integer('streak_days')->default(0);
            $table->integer('consistency_rate')->default(0);
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('trusted_email')->nullable();
            $table->boolean('alert_on_critical')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'target_score',
                'streak_days',
                'consistency_rate',
                'emergency_contact_name',
                'emergency_contact_phone',
                'trusted_email',
                'alert_on_critical'
            ]);
        });
    }
};
