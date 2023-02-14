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
        Schema::create('ders_plani', function (Blueprint $table) {
            $table->id();
            $table->integer('kurum_id');
            $table->integer('ders_id');
            $table->integer('sinif');
            $table->integer('ogrenci_sayisi')->nullable();
            $table->integer('sure')->nullable();
            $table->string('konu');
            $table->longText('kazanimlar')->nullable();
            $table->longText('arac_gerec')->nullable();
            $table->longText('dersin_islenisi');
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
        Schema::dropIfExists('ders_plani');
    }
};
