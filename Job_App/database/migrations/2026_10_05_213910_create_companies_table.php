<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('address');
            $table->string('industry');
            $table->string('website')->nullable();
            $table->text('description');
            $table->uuid('ownerId');
            $table->foreign('ownerId')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('ownerId');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
