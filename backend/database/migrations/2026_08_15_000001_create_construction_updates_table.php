<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('construction_updates', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('author_name');
            $table->string('author_email')->nullable();
            $table->string('author_phone')->nullable();
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_updates');
    }
};
