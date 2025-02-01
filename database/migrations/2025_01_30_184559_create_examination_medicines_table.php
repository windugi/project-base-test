<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminationMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examination_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_id')->constrained('examinations')->onDelete('cascade');
            $table->string('medicine_id', 36); // Ubah dari integer ke string
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examination_medicines');
    }
}
