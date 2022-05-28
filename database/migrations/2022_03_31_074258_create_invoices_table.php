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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice');
            $table->date('tanggal_invoice');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('jatuh_tempo');
            $table->string('masa_aktif');
            $table->decimal('total_harga', 20, 2);
            $table->bigInteger('user')->unsigned();
            $table->foreign('user')->references('id')->on('users')->onDelete('restrict');
            $table->bigInteger('klien')->unsigned();
            $table->foreign('klien')->references('id')->on('clients')->onDelete('restrict');
            $table->bigInteger('layanan')->unsigned();
            $table->foreign('layanan')->references('id')->on('services')->onDelete('restrict');
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
        Schema::dropIfExists('invoices');
    }
};
