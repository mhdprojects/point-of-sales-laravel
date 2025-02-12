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
        Schema::create('sales_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sales_id')->index()->constrained();
            $table->foreignUuid('product_id')->constrained();
            $table->decimal('qty')->default(0);
            $table->decimal('price', 12)->default(0);
            $table->decimal('subtotal', 12)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_items');
    }
};
