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
        Schema::create('group_pembayarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('subrekening_id')->constrained('subrekenings')->cascadeOnDelete();
            $table->foreignUuid('rekening_id')->constrained('rekenings')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['subrekening_id', 'rekening_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_pembayarans');
    }
};
