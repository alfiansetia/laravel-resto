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
        Schema::create('comp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('logo')->nullable();
            $table->string('fav')->nullable();
            $table->string('telp')->nullable();
            $table->string('wa')->nullable();
            $table->string('ig')->nullable();
            $table->string('fb')->nullable();
            $table->string('footer_struk')->nullable();
            $table->enum('tax', ['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('comp');
    }
};
