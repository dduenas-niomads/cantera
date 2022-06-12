<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cancha_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('reservations_id')->nullable();            
            $table->string('reservation_date_start_iso')->nullable();
            $table->string('reservation_date_end_iso')->nullable();
            $table->date('reservation_date')->nullable();
            $table->time('reservation_hour')->nullable();
            $table->date('reservation_date_end')->nullable();
            $table->time('reservation_hour_end')->nullable();
            $table->string('reservation_hour_hh', 2)->nullable();
            $table->string('reservation_hour_mm', 2)->nullable();
            $table->string('reservation_hour_ampm', 2)->nullable();
            $table->integer('reservation_time')->nullable();
            $table->integer('additional_time')->default(0);
            $table->string('detail')->nullable();
            $table->decimal('payment', 12, 2)->nullable();
            $table->decimal('price_pr_hour', 12, 2)->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
