<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function($table) {
            $table->string('currency', 3)->default('USD');
            $table->decimal('total_cost', 19, 4)->nullable();
            $table->string('notary', 4)->nullable();
            $table->string('n_kardex', 4)->nullable();
            $table->string('n_title', 4)->nullable();
            $table->json('files_json')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
