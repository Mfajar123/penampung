<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadSkpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_skpis', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('nim');
            $table->string('sertifikat_ospek');
            $table->string('sertifikat_seminar');
            $table->string('sertifikat_bnsp');
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
        Schema::dropIfExists('upload_skpis');
    }
}
