<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoSistemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao_sistema', function (Blueprint $table) {

            $table->string('co_usuario');
            $table->bigInteger('co_tipo_usuario');
            $table->bigInteger('co_sistema');
            $table->char('in_ativo', 100);
            $table->string('co_usuario_atualizacao');
            $table->string('dt_atualizacao');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissao_sistema');
    }
}