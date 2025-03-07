<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessLogsTable extends Migration
{
    public function up()
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Permite registrar acessos de usuários não autenticados
            $table->timestamp('accessed_at')->useCurrent(); // Registra o horário do acesso
            $table->ipAddress('ip_address')->nullable(); // Armazena o IP do usuário
            $table->string('user_agent')->nullable(); // Armazena o agente do usuário (navegador, etc.)
            $table->timestamps();

            // Define a chave estrangeira para a tabela users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('access_logs');
    }
}
