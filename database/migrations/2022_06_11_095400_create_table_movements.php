<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->biginteger('cancha_id')->unsigned(); 
            $table->index('cancha_id');
            $table->biginteger('ref_document_id')->unsigned(); 
            $table->index('ref_document_id');

            $table->tinyInteger('type_movement')->default(1);
            $table->string('type_movement_name')->default(1);
            $table->date('date_start')->nullable();
            $table->json('items')->nullable();
            $table->decimal('total_amount', 19, 4)->default(0);
            $table->string('ref_document')->nullable();
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
        Schema::dropIfExists('movements');
    }
}
