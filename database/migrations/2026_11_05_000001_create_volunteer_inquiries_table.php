<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_no', 30);
            $table->string('alt_mobile_no', 30)->nullable();
            $table->string('email');
            $table->text('address');
            $table->string('pin_code', 10);
            $table->string('aadhar_card_path');
            $table->string('pan_card_path');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_inquiries');
    }
};
