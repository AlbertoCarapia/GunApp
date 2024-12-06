<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLtypeOfficerTable extends Migration
{
    public function up()
    {
        Schema::create('ltype_officer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ltype_id');
            $table->unsignedBigInteger('officer_id');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('ltype_id')->references('id')->on('l_types')->onDelete('cascade');
            $table->foreign('officer_id')->references('id')->on('officers')->onDelete('cascade');

            // Índice único para evitar duplicados
            $table->unique(['ltype_id', 'officer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ltype_officer');
    }
}
