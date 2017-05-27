<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorTablesAndModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('action_history', 'balance_log');
        Schema::table('images', function (Blueprint $table) {
            $table->renameColumn('item_id', 'owner_id');
            $table->renameColumn('module', 'owner_type');
        });
        Schema::table('deals', function (Blueprint $table) {
            $table->renameColumn('module', 'item_type');
        });
        Schema::rename('chatter_discussion', 'forum_discussion');
        Schema::table('forum_discussion', function (Blueprint $table) {
            $table->renameColumn('chatter_category_id', 'category_id');
        });
        Schema::rename('chatter_post', 'forum_post');
        Schema::table('forum_post', function (Blueprint $table) {
            $table->renameColumn('chatter_discussion_id', 'discussion_id');
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
