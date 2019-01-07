<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('artist_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->date('date');
            $table->string('hour')->nullable();
            $table->integer('amount')->unsigned();
            $table->text('details')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('artist_id')->references('id')->on('artists');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
