<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_administradora_id_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdministradoraIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Permite nulo para admin, mas você poderá validar no controller
            $table->unsignedBigInteger('administradora_id')->nullable()->after('id');
            $table->foreign('administradora_id')->references('id')->on('administradoras')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['administradora_id']);
            $table->dropColumn('administradora_id');
        });
    }
}

