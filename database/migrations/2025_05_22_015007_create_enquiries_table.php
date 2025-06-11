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
            $table->decimal('total_amount', 10, 2)->nullable();
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
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enquiries');
    }
}
