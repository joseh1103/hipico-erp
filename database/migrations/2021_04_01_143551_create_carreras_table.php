<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jornada_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('carrera')->unsigned();
            $table->string('distance');
            $table->string('detail');
            $table->time('hour');
            $table->decimal('incentive', 15, 2)->default(0);
            $table->boolean('status_cierre');
            $table->boolean('status_movil');
            $table->string('pizarra')->nullable();
            $table->string('dividendo_ganador')->nullable();
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
        Schema::dropIfExists('carreras');
    }
}
