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
        Schema::create('dtorder', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->integer('price')->default(0);
            $table->integer('disc')->default(0);
            $table->integer('qty')->default(0);
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('order')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('menu_id')->references('id')->on('menu')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtorder');
    }
};
