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
        Schema::create('autodebet_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('autodebet_id')->nullable()->constrained('autodebets')->nullOnDelete();
            $table->foreignUuid('rekening_id')->constrained('rekenings');
            $table->foreignUuid('rekening_tujuan_id')->nullable()->constrained('rekenings');
            $table->foreignUuid('subrekening_id')->nullable()->constrained('subrekenings');
            $table->string('periode', 7)->index(); // YYYY-MM
            $table->decimal('nominal', 15, 2)->default(0.00);
            $table->string('code', 5)->index(); // 00=SUKSES, 03=SUDAH LUNAS, 05=BUKAN SISWA, 09=SALDO KURANG, dst
            $table->string('status_text', 100);
            $table->string('keterangan', 255)->nullable();
            $table->foreignUuid('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autodebet_logs');
    }
};
