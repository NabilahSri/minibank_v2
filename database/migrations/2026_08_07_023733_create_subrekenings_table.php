<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subrekenings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rekening_id')->constrained('rekenings')->cascadeOnDelete();
            $table->string('kode_subrekening', 10);
            $table->string('subrekening', 100);
            $table->year('tahun_pembayaran');
            $table->decimal('nominal', 15, 2)->default(0.00);
            $table->enum('kategori', ['umum', 'siswa'])->default('siswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subrekenings');
    }
};
