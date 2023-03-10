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
        Schema::create('kurum_ogretmen_talep', function (Blueprint $table) {
            $table->id();
            $table->integer("kurum_id");
            $table->integer("ogretmen_id");
            $table->boolean("sonuc")->nullable();
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
        Schema::dropIfExists('kurum_ogretmen_talep');
    }
};
