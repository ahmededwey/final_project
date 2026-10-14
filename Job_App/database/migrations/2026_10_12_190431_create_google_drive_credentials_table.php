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
        Schema::create('google_drive_credentials', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->uuid('connectedByUserId')->nullable();
            $table->text('accessToken');
            $table->text('refreshToken');
            $table->timestamp('expiresAt')->nullable();
            $table->foreign('connectedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_drive_credentials');
    }
};
