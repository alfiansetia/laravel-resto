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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('name');
            $table->unsignedBigInteger('table_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('date', $precision = 0)->useCurrent();
            $table->enum('category', ['take away', 'dine in'])->default('dine in');
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->integer('total')->default(0);
            $table->integer('bill')->default(0);
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->foreign('table_id')->references('id')->on('table')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
