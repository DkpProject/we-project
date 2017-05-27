<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
           $table->dropColumn('action');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthday')->change();
            $table->integer('group_id')->default(0);
            $table->dropColumn('is_admin');
        });
        Schema::table('users_roles', function (Blueprint $table) {
            $table->boolean('changeable')->default(0);
            $table->text('permission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
