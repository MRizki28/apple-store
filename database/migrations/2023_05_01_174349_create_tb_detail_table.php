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
        Schema::create('tb_detail', function (Blueprint $table) {
            $table->id();
            $table->text('uuid');
            $table->string('ram');
            $table->string('storage');
            $table->string('os');
            $table->string('cpu');
            $table->string('baterry');
            $table->string('camera');
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
        Schema::dropIfExists('tb_detail');
    }
};
