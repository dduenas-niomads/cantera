<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->biginteger('cars_id')->unsigned(); 
            $table->index('cars_id');
            $table->foreign('cars_id')->references('id')->on('cars')->onDelete('no action');

            $table->biginteger('taxations_id')->unsigned();
            $table->index('taxations_id');
            $table->foreign('taxations_id')->references('id')->on('taxations')->onDelete('no action');

            $table->biginteger('clients_id')->unsigned(); 
            $table->index('clients_id');
            $table->foreign('clients_id')->references('id')->on('clients')->onDelete('no action');

            $table->string('register_date', 10)->nullable();
            $table->decimal('price_sale', 19, 4)->default(0);
            $table->decimal('price_compra', 19, 4)->default(0);
            $table->decimal('total_expenses', 19, 4)->default(0);
            $table->decimal('taxes', 19, 4)->default(0);
            $table->decimal('total_invoiced', 19, 4)->default(0);
            $table->string('type_document', 2)->default('01');
            $table->string('document_serie', 4)->nullable();
            $table->biginteger('document_number')->unsigned()->default(0);
            $table->string('client')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
