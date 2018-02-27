<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaoUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cao_usuario', function (Blueprint $table) {
            $table->string('co_usuario');
            $table->string('no_usuario');
            $table->string('ds_senha');
            $table->string('co_usuario_autorizacao');
            $table->bigInteger('nu_matricula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cao_usuario');
    }
}

