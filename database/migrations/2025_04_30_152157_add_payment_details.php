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
        Schema::table('payment_details', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payment_infos')->onDelete('cascade');
            $table->string('payment_method')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->decimal('fee',10,2)->nullable();
            $table->decimal('charged_amount',10,2)->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('sender_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
