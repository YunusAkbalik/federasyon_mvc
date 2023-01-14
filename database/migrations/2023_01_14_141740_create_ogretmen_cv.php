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
        Schema::create('ogretmen_cv', function (Blueprint $table) {
            $table->id();
            $table->integer('ogretmen_id');
            $table->string('okul');
            $table->string('bolum');
            $table->date('mezun_tarihi');
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
        Schema::dropIfExists('ogretmen_cv');
    }
};
