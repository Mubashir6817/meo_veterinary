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
            $table->id();
            $table->unsignedBigInteger('customers_id')->nullable();
            $table->foreign('customers_id')->references('id')->on('customers');
            $table->date('sale_date');
            $table->integer('total_amount')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('net_amount')->default(0);
            $table->integer('paid_amount')->default(0);
            $table->integer('due_amount')->default(0);
            $table->string('payment_status')->default('Unpaid');
            $table->timestamps();
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
