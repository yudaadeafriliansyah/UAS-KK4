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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('motor_id');
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_code');
            $table->string('nama');
            $table->string('email');
            $table->string('nomer_hp');
            $table->string('alamat');
            $table->string('identiity_number');
            $table->string('gambar_sim');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('transaction_total');
            $table->string('transaction_status');

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
        Schema::dropIfExists('transactions');
    }
};
