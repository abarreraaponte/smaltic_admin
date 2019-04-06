<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_id')->unsigned();
            $table->bigInteger('payment_method_id')->unsigned()->nullable();
            $table->bigInteger('job_id')->unsigned()->nullable();
            $table->bigInteger('expense_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('transfer_id')->unsigned()->nullable();
            $table->date('date');
            $table->integer('amount');
            $table->string('reference')->nullable();
            $table->boolean('is_downpayment')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('expense_id')->references('id')->on('expenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
