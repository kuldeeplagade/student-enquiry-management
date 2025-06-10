<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->date('dob');
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->string('blood_group')->nullable();
            $table->string('father_mobile');
            $table->string('mother_mobile')->nullable();
            $table->string('landline')->nullable();
            $table->string('email')->nullable();
            $table->enum('admission_for', ['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG']);
            $table->string('sibling1_name')->nullable();
            $table->enum('sibling1_sex', ['Male', 'Female', 'Other'])->nullable();
            $table->date('sibling1_dob')->nullable();
            $table->string('sibling2_name')->nullable();
            $table->enum('sibling2_sex', ['Male', 'Female', 'Other'])->nullable();
            $table->date('sibling2_dob')->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
            $table->enum('payment_status', ['Pending', 'Payment Started'])->default('Pending');
            $table->enum('payment_mode', ['Cash', 'UPI', 'Bank Transfer'])->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->default(25000); // Default total amount
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enquiries');
    }
}
