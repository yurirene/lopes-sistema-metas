<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanilhaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilha_items', function (Blueprint $table) {
            $table->id();
            $table->date('data')->nullable();
            $table->string('cod_gerente')->nullable();
            $table->string('gerente')->nullable();
            $table->string('familia_produto')->nullable();
            $table->string('subgrupo_produto')->nullable();
            $table->string('cod_produto')->nullable();
            $table->string('produto')->nullable();
            $table->string('cod_empresa')->nullable();
            $table->string('empresa')->nullable();
            $table->string('qtd_meta')->nullable();
            $table->string('volume_meta_kg')->nullable();
            $table->string('meta_valor')->nullable();
            $table->string('cob_meta')->nullable();
            $table->string('cod_subgrupo_produto')->nullable();
            $table->string('tipo_subgrupo_produto')->nullable();
            $table->string('nova_meta')->nullable();
            $table->string('cod_supervisor');
            $table->string('cod_representante');
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('planilha_id')->unsigned();
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
        Schema::dropIfExists('planilha_items');
    }
}
