<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicines_id')->nullable();
            $table->foreign('medicines_id')->references('id')->on('medicines');
            $table->string('batch_no');
            $table->date('stock_in_date');
            $table->date('expiry_date');
            $table->integer('purchase_price');
            $table->integer('sale_price');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
