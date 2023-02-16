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
        Schema::create('ders_programi', function (Blueprint $table) {
            $table->id();
            $table->integer('kurum_id');
            $table->integer('sinif_id');
            $table->integer('ders_id');
            $table->integer('gun_id');
            $table->string('baslangic');
            $table->string('bitis');
            $table->integer('ogretmen_id');
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
        Schema::dropIfExists('ders_programi');
    }
};
