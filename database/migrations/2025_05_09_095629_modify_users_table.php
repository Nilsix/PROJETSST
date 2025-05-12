<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('numAgent')->unique();
            $table->dropColumn('nomSite');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nom');
            $table->string('prenom');
            $table->unsignedBigInteger('site_id');
            $table->dropColumn('numAgent');
        });
    }
};
