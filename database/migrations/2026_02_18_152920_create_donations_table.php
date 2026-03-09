<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {

            $table->id();

            $table->string('donor_name');
            $table->string('donor_email');

            $table->string('donor_phone')->nullable();
            $table->text('donor_address')->nullable();

            // new address fields
            $table->string('donor_city')->nullable();
            $table->string('donor_state')->nullable();
            $table->string('donor_pincode')->nullable();

            // donation details
            $table->decimal('amount',10,2);
            $table->string('donation_purpose')->nullable();
            $table->dateTime('donation_date')->nullable();

            // 80G related
            $table->boolean('need_80g')->default(false);
            $table->string('donor_pan',10)->nullable();

            // razorpay
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();

            $table->enum('payment_status',['Pending','Paid','Failed'])
                  ->default('Pending');

            $table->string('receipt_number')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};