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
            // Add new columns
            $table->string('phone');
            $table->text('description');
            $table->foreignId('role_id')->constrained('roles');
            $table->string('profile_image')->nullable(); // Add profile image column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns if migrating down
            $table->string('phone');
            $table->text('description');
            $table->foreignId('role_id')->constrained('roles');
            $table->string('profile_image')->nullable(); // Add profile image column
        });
    }
};
