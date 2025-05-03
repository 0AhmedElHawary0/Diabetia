<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('patient_companion', function (Blueprint $table) {
            $table->bigInteger('companion_id')->nullable()->unsigned()->index();
            $table->foreign('companion_id')->references('id')->on('companions')->onDelete('cascade');
            $table->bigInteger('patient_id')->nullable()->unsigned()->index();
            $table->foreign('patient_id')->references('id')->on('sensor_patients')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('patient_companion');
    }
};
