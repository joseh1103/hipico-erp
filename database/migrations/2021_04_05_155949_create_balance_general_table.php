<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceGeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_general', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('monto', 15, 2);
            $table->string('description');
            $table->enum('operations', ['posos', 'premio', 'jugada', 'retiro']);

            $table->integer('poso_id')->nullable()->unique();

            $table->integer('subastas_id')->nullable()->unsigned();
            $table->foreignId('jornada_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->integer('carrera_id')->nullable()->unsigned();

            $table->integer('status')->default(1);
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
        Schema::dropIfExists('balance_general');
    }
}
