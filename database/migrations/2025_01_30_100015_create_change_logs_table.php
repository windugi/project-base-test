<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_log', function (Blueprint $table) {
            $table->id();
            $table->string('user_role'); // 'doctor' atau 'pharmacist'
            $table->string('action'); // 'created', 'updated', 'deleted'
            $table->json('data'); // Data yang diubah
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
        Schema::dropIfExists('change_log');
    }
}
