<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('job_applications', function (Blueprint $table) {
    $table->uuid('id')->primary();

    $table->enum('status',['pending','accepted','rejected'])->default('pending');

$table->decimal('aiGeneratedScore', 4, 2)->nullable();
    $table->text('aiGeneratedFeedback')->nullable();

    $table->uuid('userId');
    $table->uuid('resumeId');
    $table->uuid('jobVacancyId');

    $table->foreign('userId')
        ->references('id')
        ->on('users')
        ->cascadeOnDelete();

    $table->foreign('resumeId')
        ->references('id')
        ->on('resumes')
        ->cascadeOnDelete();

    $table->foreign('jobVacancyId')
        ->references('id')
        ->on('job_vacancies')
        ->cascadeOnDelete();

    $table->timestamps();
    $table->softDeletes();

    $table->index('userId');
    $table->index('resumeId');
    $table->index('jobVacancyId');

    $table->unique(['userId', 'jobVacancyId']);
});
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};