<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarEntryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_entry_details', function (Blueprint $table) {
            $table->id();
            $table->biginteger('cars_id')->unsigned(); 
            $table->index('cars_id');
            $table->foreign('cars_id')->references('id')->on('cars')->onDelete('no action');

            $table->string('soat_code', 100)->nullable();
            $table->string('soat_end_date', 10)->nullable();
            $table->string('tech_review_end_date', 10)->nullable();
            $table->tinyInteger('sat_taxes')->default(0);
            $table->string('motor_serie', 100)->nullable();
            $table->integer('kilometers')->nullable()->default(0);
            $table->integer('cylinders')->nullable()->default(0);
            $table->integer('cc')->nullable()->default(0);
            $table->integer('hp')->nullable()->default(0);
            $table->integer('torque')->nullable()->default(0);
            $table->integer('doors_number')->nullable()->default(0);
            $table->string('circulation_end_date', 10)->nullable();
            $table->string('transmition', 8)->nullable();
            $table->string('traction', 8)->nullable();
            $table->string('next_service_date', 10)->nullable();
            $table->integer('work_hours')->nullable()->default(0);
            $table->decimal('ticket_amount_sutran', 19, 4)->nullable()->default(0);
            $table->decimal('ticket_amount_sat', 19, 4)->nullable()->default(0);
            $table->json('options_json')->nullable();
            $table->string('observations')->nullable();
            
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
        Schema::dropIfExists('car_entry_details');
    }
}
