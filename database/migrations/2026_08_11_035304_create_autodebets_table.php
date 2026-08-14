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
        Schema::create('autodebets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rekening_id')->constrained('rekenings');
            $table->foreignUuid('rekening_tujuan_id')->constrained('rekenings');
            $table->foreignUuid('subrekening_id')->constrained('subrekenings');
            $table->foreignUuid('user_id')->constrained('users');
            $table->unsignedTinyInteger('tgl_penarikan');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autodebets');
    }
};
