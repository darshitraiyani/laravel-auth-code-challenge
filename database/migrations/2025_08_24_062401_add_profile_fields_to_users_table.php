<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->string('registration_step')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dob');
            $table->dropColumn('contact_number');
            $table->dropColumn('profile_completed');
            $table->dropColumn('confirmed_at');
        });
    }
};
