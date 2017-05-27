<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deal_id');
            $table->integer('user_id');
            $table->text('comment')->nullable();
            $table->integer('rating')->default(0);
            $table->string('person')->nullable();
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
        //
    }
}
