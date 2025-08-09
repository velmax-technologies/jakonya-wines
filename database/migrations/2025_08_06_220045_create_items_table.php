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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('sku')->unique()->nullable();
            $table->string('upc')->unique()->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes(); // Allows for soft deletion of items
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
