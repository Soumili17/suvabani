<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();

            // Photo & Signature
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();

            // Personal Details
            $table->string('fullname');
            $table->string('parentname');
            $table->date('dob');
            $table->string('gender');
            $table->string('nationality');
            $table->string('occupation');
            $table->text('address');
            $table->string('phone');
            $table->string('email');

            // ID Proof
                       
            
            $table->enum('idproof', [
                'Aadhar',
                'Voter',
                'Driving',
                'PAN',
                'Passport',
                'Other'
            ]);
            

            $table->string('idproof_other')->nullable();
            $table->string('idnumber');
            $table->string('idfile')->nullable();

            // Membership
            $table->json('membership')->nullable();
            $table->integer('paidamount')->nullable();
            $table->json('membertype')->nullable();

            // Interest
            $table->json('interest')->nullable();
            $table->string('interest_other')->nullable();

            // Other Info
            $table->text('experience')->nullable();
            $table->string('languages')->nullable();
            $table->json('time')->nullable();
            $table->text('reason')->nullable();
            $table->string('ref_name')->nullable();
            $table->string('ref_mobile')->nullable();

            // Declaration
            $table->date('declaration_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
