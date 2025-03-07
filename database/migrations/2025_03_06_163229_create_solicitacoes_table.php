<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('assunto');
            $table->text('descricao');
            $table->string('categoria')->nullable(); // financeiro, tecnico, geral
            $table->string('status')->default('aberto'); // aberto, em-andamento, fechado, etc.
            $table->string('anexo')->nullable(); // caminho do arquivo (se houver upload)
            $table->timestamps();

            // Chave estrangeira para a tabela users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitacoes');
    }
};
