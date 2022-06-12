<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarEntryExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_entry_expenses', function (Blueprint $table) {
            $table->id();
            $table->biginteger('cars_id')->unsigned();
            $table->index('cars_id');
            $table->foreign('cars_id')->references('id')->on('cars')->onDelete('no action');
            $table->decimal('cost_per_day', 19, 4)->default(0);
            $table->decimal('price_sale', 19, 4)->default(0);
            $table->decimal('price_buy', 19, 4)->default(0);
            $table->string('admission_date')->nullable();
            $table->string('currency', 3)->nullable();
            $table->json('expenses_json')->nullable();
            // auditory
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->tinyInteger('flag_active')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_entry_expenses');
    }
}
