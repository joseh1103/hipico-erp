<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('typePayment', ['Transferencia', 'Pago Movil'])->default('Transferencia')->nullable();
            $table->enum('typeDocument', ['V','E','P','J','G','M','C'])->default('V')->nullable();
            $table->string('document')->nullable();
            $table->string('name_beneficiary')->nullable();
            $table->string('account_number')->nullable();
            $table->string('code_bank', 20)->nullable();
            $table->string('phone', 15)->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('bank_accounts_users');
    }
}
