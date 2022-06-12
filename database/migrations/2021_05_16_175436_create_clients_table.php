<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(1);
            $table->string('tag')->default('owner');
            $table->string('name')->nullable();
            $table->string('type_document', 2)->default('01');
            $table->string('document_number', 15)->nullable();
            $table->string('address')->nullable();
            $table->string('department')->nullable();
            $table->bigInteger('department_id')->nullable();
            $table->index('department_id');
            $table->string('province')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->index('province_id');
            $table->string('district')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->index('district_id');
            $table->string('phone', 25)->nullable();
            $table->string('phone_2', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('comentary')->nullable();
            $table->string('names')->nullable();
            $table->string('first_lastname')->nullable();
            $table->string('second_lastname')->nullable();
            $table->string('birthday', 10)->nullable();
            $table->string('rz_social')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('type_company', 6)->nullable();
            $table->tinyInteger('estado_contribuyente')->default(1);
            $table->tinyInteger('condicion_contribuyente')->default(1);
            $table->string('rl_name')->nullable();
            $table->string('rl_type_document', 2)->nullable();
            $table->string('rl_document_number', 15)->nullable();
            $table->string('rl_position')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
