<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissoesUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissoes_usuarios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('permissao_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->timestamps();

            $table->foreign('permissao_id')->references('id')->on('permissoes');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissoes_usuarios');
    }
}
