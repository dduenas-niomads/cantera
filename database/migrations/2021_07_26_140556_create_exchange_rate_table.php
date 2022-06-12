<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rate', function (Blueprint $table) {
            $table->id();
            $table->decimal('compra', 19, 4)->nullable();
            $table->decimal('venta', 19, 4)->nullable();
            $table->string('origen')->nullable();
            $table->string('moneda', 3)->default('USD');
            $table->string('fecha', 10)->nullable();
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
        Schema::dropIfExists('exchange_rate');
    }
}
