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
        Schema::create('tb_orderan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('tb_product');
            $table->string('uuid');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone_number');
            $table->string('post_code');
            $table->string('city');
            $table->string('detail_state');
            $table->integer('qty');
            $table->bigInteger('total_price');
            $table->string('snapToken');
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
        Schema::dropIfExists('tb_orderan');
    }
};
