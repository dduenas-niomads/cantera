<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSalesCantera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_cantera', function (Blueprint $table) {
            $table->id();
            $table->biginteger('reservation_id')->unsigned(); 
            $table->index('reservation_id');

            $table->biginteger('client_id')->unsigned();
            $table->index('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('no action');

            $table->biginteger('document_id')->unsigned();
            $table->index('document_id');
            $table->foreign('document_id')->references('id')->on('taxes')->onDelete('no action');

            $table->string('period', 6)->nullable();
            $table->json('items')->nullable();
            $table->decimal('total_amount', 19, 4)->default(0);
            $table->decimal('taxes', 19, 4)->default(0);
            $table->string('type_document', 2)->nullable();
            $table->string('serie', 4)->nullable();
            $table->biginteger('correlative')->unsigned()->default(0);
            // fe
            $table->json('fe_request')->nullable();
            $table->json('fe_response')->nullable();
            $table->tinyInteger('fe_status_code')->default(0);
            $table->json('fe_request_nulled')->nullable();
            $table->json('fe_response_nulled')->nullable();
            $table->tinyInteger('fe_status_code_nulled')->default(0);
            $table->string('fe_url_pdf')->nullable();
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
        Schema::dropIfExists('table_sales_cantera');
    }
}
