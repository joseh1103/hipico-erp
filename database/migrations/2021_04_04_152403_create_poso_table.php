<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_approvals_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            
            $table->string('origin_bank')->nullable();
            $table->string('destination_bank')->nullable();

            $table->integer('payment_type')->nullable();

            $table->unsignedBigInteger('id_account_user')->nullable();
            $table->foreign('id_account_user')->references('id')->on('bank_accounts_users');
            
            $table->decimal('monto', 15, 2);
            $table->integer('status_authorization')->default(0);
            $table->string('description');
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
        Schema::dropIfExists('poso');
    }
}
