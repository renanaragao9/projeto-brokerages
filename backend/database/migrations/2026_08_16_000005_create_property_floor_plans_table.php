<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_floor_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_path')->nullable();
            $table->string('tour_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_floor_plans');
    }
};
