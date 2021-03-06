<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeriksaanTelingaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaan_telinga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anak')->nullable();
            $table->string('soal1')->nullable();
            $table->string('soal2')->nullable();
            $table->string('soal3')->nullable();
            $table->string('soal4')->nullable();
            $table->string('soal5')->nullable();
            $table->string('soal6')->nullable();
            $table->string('soal7')->nullable();
            $table->datetime('waktu_pemeriksaan')->nullable();
            $table->timestamps();

            $table->foreign('id_anak')->references('id')->on('anak')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaan_telinga');
    }
}
