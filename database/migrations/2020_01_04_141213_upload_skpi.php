<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UploadSkpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skpi',function(Blueprint $table){
            $table->increment('id');
            $table->foreign('nim')->references('nim')->on('m_mahasiswa');
            $table->string('sertifikat_ospek',20);
            $table->string('sertifikat_ospek',20);
            $table->string('sertifikat_ospek',20);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
