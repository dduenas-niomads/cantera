<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxations', function (Blueprint $table) {
            $table->id();
            $table->biginteger('cars_id')->unsigned();
            $table->index('cars_id');
            $table->foreign('cars_id')->references('id')->on('cars')->onDelete('no action');
            
            $table->string('car_number', 8)->nullable();
            $table->string('taxator')->nullable();
            $table->biginteger('taxator_id')->nullable();
            $table->index('taxator_id');
            $table->string('salesman')->nullable();
            $table->biginteger('salesman_id')->nullable();
            $table->index('salesman_id');
            $table->string('currency', 3)->default('USD');
            $table->decimal('client_amount', 19, 4)->default(0);
            $table->decimal('offered_amount', 19, 4)->default(0);
            $table->string('phone', 25)->nullable();
            $table->tinyInteger('tires')->default(0);
            $table->tinyInteger('paint')->default(0);
            $table->tinyInteger('maintenance')->default(0);
            $table->tinyInteger('owners')->default(0);
            $table->string('comentary')->nullable();
            $table->json('progress_image_json')->nullable();
            $table->string('taxation_date')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('taxations');
    }
}
