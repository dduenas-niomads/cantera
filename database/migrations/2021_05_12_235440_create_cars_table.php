<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type_entry')->default(1);
            $table->string('code')->nullable();
            $table->string('brand')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->index('brand_id');
            $table->string('model')->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->index('model_id');
            $table->string('number', 8)->nullable();
            $table->string('color')->nullable();
            $table->bigInteger('color_id')->nullable();
            $table->index('color_id');
            $table->string('fab_year', 4)->nullable();
            $table->string('model_year', 4)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->decimal('price_tasacion', 19, 4)->nullable();
            $table->decimal('price_sale', 19, 4)->nullable();
            $table->decimal('price_compra', 19, 4)->nullable();
            $table->string('holder')->nullable();
            $table->bigInteger('holder_id')->nullable();
            $table->index('holder_id');
            $table->string('owner')->nullable();
            $table->bigInteger('owner_id')->nullable();
            $table->index('owner_id');
            $table->decimal('invoiced', 19, 4)->nullable();
            $table->string('n_tasacion')->nullable();
            $table->string('ref_number', 8)->nullable();
            $table->string('register_date', 10)->nullable();
            $table->string('notary')->nullable();
            $table->bigInteger('notary_id')->nullable();
            $table->index('notary_id');
            $table->string('n_kardex')->nullable();
            $table->string('n_title')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('for_sale')->default(0);
            $table->tinyInteger('type_sign')->default(1);
            $table->decimal('details_total_expenses', 19, 4)->nullable();
            $table->decimal('details_price_acta', 19, 4)->nullable();
            $table->decimal('details_sale_price', 19, 4)->nullable();
            $table->json('images_json')->nullable();
            
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
        Schema::dropIfExists('cars');
    }
}
