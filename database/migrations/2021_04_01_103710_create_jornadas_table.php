<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hipodromo_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->decimal('commission', 5, 2)->default(0);
            $table->date('date');
            $table->boolean('status');
            $table->boolean('movil');
            $table->integer('typeJornada')->default(1); // 1 = adelantada , 2 = en vivo 
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currency');
            $table->string('youtube_id')->nullable();
            $table->string('url_retrospecto')->nullable();
            $table->decimal('monto', 15, 2)->nullable();
            $table->foreignId('jornada_master_id')->nullable();
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
        Schema::dropIfExists('jornadas');
    }
}
