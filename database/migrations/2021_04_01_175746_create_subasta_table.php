<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubastaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subasta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('jornada_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('carrera_id')->nullable()->unsigned();
            $table->integer('ejemplar');
            $table->string('name_ejemplar');
            $table->decimal('monto', 15, 2);
            $table->integer('winner')->default(0);
            $table->decimal('monto_winner', 15, 2);
            $table->integer('status_retired')->default(1);
            $table->integer('status_close')->default(1);
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
        Schema::dropIfExists('subasta');
    }
}
