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
        Schema::create('dtreqstock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reqstock_id');
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->enum('type', ['adjust', 'add'])->default('add');
            $table->integer('qty')->default(0);
            $table->foreign('reqstock_id')->references('id')->on('reqstock')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('menu_id')->references('id')->on('menu')->cascadeOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('dtreqstocks');
    }
};
