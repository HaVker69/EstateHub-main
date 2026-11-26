<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_type_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->decimal('area', 8, 2);
            $table->unsignedSmallInteger('rooms');
            $table->string('city');
            $table->string('address');
            $table->string('status')->default('pending')->index();
            $table->string('rejection_reason')->nullable();
            $table->timestamps();

            $table->index(['city']);
            $table->index(['price']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
