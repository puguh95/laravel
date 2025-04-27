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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // No Order
            $table->string('uuid')->unique();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->string('reference');
            $table->string('order_id', 50);
            $table->string('name');
            $table->string('email');
            $table->enum('gender', ['L', 'P']);
            $table->string('phone');
            $table->text('notes')->nullable();
            $table->string('item');
            $table->bigInteger('amount');
            $table->string('payment_no')->nullable();
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->string('checked_by')->nullable();
            $table->string('payment_url');
            $table->string('payment_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
