<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('car_id');
            $table->dateTime('period_start_date');
            $table->dateTime('expected_end_date_period');
            $table->dateTime('end_date_performed_period');
            $table->float('daily_rate_value', 8, 2);
            $table->integer('km_initial');
            $table->integer('km_final');
            $table->timestamps();

            // Chaves estrangeiras de Client e Car. Esta é a tabela pivô
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('car_id')->references('id')->on('cars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('models', function (Blueprint $table) {
            $table->dropForeign('locations_client_id_foreign');
            $table->dropForeign('locations_car_id_foreign');
        });

        Schema::dropIfExists('locations');
    }
};
