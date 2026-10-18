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
        Schema::create('listings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('cat_name')->nullable();
    $table->string('breed')->nullable();
    $table->unsignedInteger('age_months')->nullable();
    $table->string('gender')->nullable();
    $table->string('location');
    $table->decimal('price', 12, 2)->default(0);
    $table->string('image_path')->nullable();
    $table->string('status')->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
