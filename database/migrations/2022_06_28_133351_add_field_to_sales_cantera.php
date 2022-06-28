<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToSalesCantera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_cantera', function (Blueprint $table) {
            $table->biginteger('cancha_id')->unsigned()->nullable(); 
            $table->index('cancha_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_cantera', function (Blueprint $table) {
            //
        });
    }
}
