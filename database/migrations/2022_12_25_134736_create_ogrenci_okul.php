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
        Schema::create('ogrenci_okul', function (Blueprint $table) {
            $table->id();
            $table->integer('okul_id');
            $table->integer('ogrenci_id');
            $table->string('sinif');
            $table->string('sube')->nullable();
            $table->string('brans')->nullable();
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
        Schema::dropIfExists('ogrenci_okul');
    }
};
