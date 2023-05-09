<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('catmenu_id')->nullable();
            $table->integer('price')->default(0);
            $table->integer('disc')->default(0);
            $table->integer('stock')->default(0);
            $table->string('img')->nullable();
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->foreign('catmenu_id')->references('id')->on('catmenu')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
};
