<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string("candidate_name");
            $table->date("dob");
            $table->string("parent_contact");
            $table->enum("admission_for",["Playgroup","Nursery","Jr.KG","Sr.KG"]);
            $table->timestamps();

            // Add unique constraint
            $table->unique(['parent_contact', 'admission_for']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enquiries');
    }
};
