<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('broker_id')->nullable()->constrained('brokers')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_bookings');
    }
};
