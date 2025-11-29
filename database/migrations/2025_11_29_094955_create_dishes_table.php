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
        Schema::create('dishes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->string('image')->nullable();
    $table->text('description');
    $table->decimal('price', 8, 2);
    $table->integer('calories');
    $table->integer('protein');
    $table->integer('fat')->nullable();
    $table->integer('fiber')->nullable();
    $table->integer('carbs')->nullable();
    $table->decimal('rating', 3, 2)->default(0);
    $table->boolean('is_favorite')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
