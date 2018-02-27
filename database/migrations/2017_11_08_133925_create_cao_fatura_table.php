<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaoFaturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cao_fatura', function (Blueprint $table) {
            $table->integer('co_fatura');
            $table->integer('co_cliente');
            $table->integer('co_sistema');
            $table->integer('co_os');
            $table->integer('num_nf');
            $table->double('total');
            $table->double('valor');
            $table->date('data_emissao');
            $table->text('corpo_nf');
            $table->double('comissao_cn');
            $table->double('total_imp_inc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cao_fatura');
    }
}