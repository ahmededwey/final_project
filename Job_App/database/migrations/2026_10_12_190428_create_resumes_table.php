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
        Schema::create('resumes', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('fileName');
            $table->string('fileUrl');
            $table->text('contactDetails')->nullable();
            $table->text('education')->nullable();
            $table->text('summary')->nullable();
            $table->text('skills')->nullable();
            $table->text('experience')->nullable();
            $table->uuid('userId');
            $table->foreign('userId')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('userId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
