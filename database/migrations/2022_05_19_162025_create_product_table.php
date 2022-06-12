<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('category')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('brand')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price_compra', 12, 2)->default(0);
            $table->decimal('price_sale', 12, 2)->default(0);
            $table->tinyInteger('type_product')->default(1);
            $table->integer('stock')->default(0);
            $table->integer('minimun_stock')->default(0);
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
        Schema::dropIfExists('products');
    }
}