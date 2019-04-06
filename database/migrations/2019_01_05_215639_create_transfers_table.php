<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_account_id')->unsigned();
            $table->bigInteger('end_account_id')->unsigned();
            $table->date('date');
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->integer('amount');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('origin_account_id')->references('id')->on('accounts');
            $table->foreign('end_account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
