<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('resumes', function (Blueprint $table) {
    $table->uuid('id')->primary();

    $table->string('fileName');
    $table->string('fileUrl');

    $table->text('contactDetails')->nullable();
    $table->longText('education')->nullable();
    $table->longText('summary')->nullable();
    $table->longText('skills')->nullable();
    $table->longText('experience')->nullable();

    $table->uuid('userId');

    $table->foreign('userId')
        ->references('id')
        ->on('users')
        ->cascadeOnDelete();

    $table->timestamps();
    $table->softDeletes();

    $table->index('userId');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};