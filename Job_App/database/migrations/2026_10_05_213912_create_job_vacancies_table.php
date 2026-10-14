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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->decimal('salary', 10, 2)->nullable();
            $table->enum('type', ['Full-Time', 'Contract', 'Remote', 'Hybrid'])->default('Full-Time');
            $table->uuid('companyId');
            $table->uuid('categoryId');
            $table->unsignedInteger('viewCount')->default(0);

            $table->foreign('companyId')->references('id')->on('companies')->cascadeOnDelete();
            $table->foreign('categoryId')->references('id')->on('job_categories')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('companyId');
            $table->index('categoryId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
