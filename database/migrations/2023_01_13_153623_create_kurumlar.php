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
        Schema::create('kurumlar', function (Blueprint $table) {
            $table->id();
            $table->string('unvan');
            $table->string('telefon');
            $table->longText('adres');
            $table->string('vergi_dairesi');
            $table->string('vergi_no');
            $table->string('yetkili_kisi');
            $table->string('yetkili_telefon');
            $table->string('wp_hatti')->nullable();
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
        Schema::dropIfExists('kurumlar');
    }
};
