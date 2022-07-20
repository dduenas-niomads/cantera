<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsCompaniesIdToProds2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('family')->nullable();
            $table->integer('family_id')->nullable();
            $table->string('subfamily')->nullable();
            $table->integer('subfamily_id')->nullable();
            $table->string('generic')->nullable();
            $table->integer('generic_id')->nullable();
            $table->string('lab')->nullable();
            $table->integer('lab_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
