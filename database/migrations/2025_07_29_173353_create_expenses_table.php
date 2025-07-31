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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Expense title (e.g., Rent, Salary)
            $table->decimal('amount', 10, 2);
            $table->string('payment_mode');
            // Foreign key category
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('expense_categories')
                ->onDelete('set null');
            $table->string('branch_name');
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
