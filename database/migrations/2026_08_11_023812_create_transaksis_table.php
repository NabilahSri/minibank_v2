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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rekening_id')->constrained('rekenings');
            $table->foreignUuid('rekening_tujuan_id')->nullable()->constrained('rekenings');
            $table->foreignUuid('subrekening_id')->nullable()->constrained('subrekenings');
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('sandi_id')->constrained('sandi_transaksis');
            $table->foreignUuid('via_id')->nullable()->constrained('via_transaksis');
            $table->decimal('nominal', 15, 2);
            $table->text('ref')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('waktu')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
