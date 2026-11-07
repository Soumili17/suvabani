<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained('memberships')->onDelete('cascade');
            $table->string('razorpay_payment_id')->unique();
            $table->string('razorpay_subscription_id')->nullable();
            $table->string('razorpay_invoice_id')->nullable();
            $table->bigInteger('amount'); // stored in paise
            $table->string('currency')->default('INR');
            $table->enum('payment_status', ['captured','failed','refunded','authorized'])->default('captured');
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_payments');
    }
};
?>
