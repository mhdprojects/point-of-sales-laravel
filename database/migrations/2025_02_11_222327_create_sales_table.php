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
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('date');
            $table->string('code', 30);
            $table->string('customer_name')->nullable();
            $table->foreignUuid('payment_method_id')->constrained();
            $table->decimal('subtotal', 12)->default(0);
            $table->decimal('disc_percent')->default(0);
            $table->decimal('disc_amount', 12)->default(0);
            $table->decimal('total', 12)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
