<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SomeBugFixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals_messages', function (Blueprint $table) {
            $table->dropColumn('person');
            $table->tinyInteger('finish');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals_messages', function (Blueprint $table) {
            $table->string('person');
            $table->dropColumn('finish');
        });
    }
}
