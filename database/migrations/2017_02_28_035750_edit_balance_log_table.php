<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditBalanceLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('balance_log', function (Blueprint $table) {
            $table->dropColumn('descr');
            $table->renameColumn('deal_id', 'item_id');
            $table->string('action');
            $table->float('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('balance_log', function (Blueprint $table) {
            $table->text('descr');
            $table->renameColumn('item_id', 'deal_id');
            $table->dropColumn('action');
            $table->dropColumn('value');
        });
    }
}
