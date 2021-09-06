<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('typePayment', ['Zelle', 'Transferencia', 'Pago Movil'])->default('Transferencia')->nullable();
            $table->enum('typeDocument', ['V','E','P','J','G','M','C'])->default('V')->nullable();
            $table->string('document')->nullable();
            $table->string('name_beneficiary')->nullable();
            $table->string('account_number')->nullable();
            $table->string('code_bank', 20)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currency');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('payment_methods');
    }
}
