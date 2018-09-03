<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiReferenceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_reference_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference');
            $table->string('provider');
            $table->enum('status', ['passed','failed','pending']);
            $table->unsignedTinyInteger('string');
            $table->integer('failed');
            $table->timestamps();
            $table->unique(['reference', 'provider']);
            $table->foreign('reference')->references('reference')->on('api_reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_reference_providers');
    }
}
