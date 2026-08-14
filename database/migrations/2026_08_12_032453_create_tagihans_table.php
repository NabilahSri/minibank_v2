<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_pembayaran', 30);
            $table->string('nomor_induk', 30);
            $table->string('nama', 150);
            $table->string('kode_fakultas', 20)->nullable();
            $table->string('nama_fakultas', 100)->nullable();
            $table->string('kode_prodi', 20)->nullable();
            $table->string('nama_prodi', 100)->nullable();
            $table->string('kode_periode', 20)->nullable();
            $table->string('nama_periode', 100)->nullable();
            $table->string('strata', 20)->nullable();
            $table->string('angkatan', 10)->nullable();
            $table->boolean('is_tagihan_aktif')->default(true);
            $table->date('tanggal')->nullable();
            $table->dateTime('waktu_berlaku')->nullable();
            $table->dateTime('waktu_berakhir')->nullable();
            $table->integer('urutan_antrian')->default(0);
            $table->decimal('total_nilai_tagihan', 15, 2)->default(0.00);
            $table->enum('pembayaran_atau_voucher', ['PEMBAYARAN', 'VOUCHER'])->default('PEMBAYARAN');
            $table->string('voucher_nama', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
