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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 50);
            $table->string('name');
            $table->foreignUuid('category_id')->constrained();
            $table->foreignUuid('unit_id')->constrained();
            $table->decimal('stock', 12)->default(0);
            $table->decimal('price', 12)->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
