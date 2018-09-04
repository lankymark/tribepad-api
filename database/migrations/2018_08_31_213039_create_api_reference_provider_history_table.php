<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiReferenceProviderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_reference_provider_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id', false, true);
            $table->enum('status', ['passed','failed','pending']);
            $table->unsignedTinyInteger('score');
            $table->integer('failed');
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('provider_id')->references('id')->on('api_reference_providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_reference_provider_history');
    }
}
